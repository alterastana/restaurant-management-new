<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\Restoran;
use App\Models\TableRestaurant;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentGatewayService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function create(Restoran $restaurant)
    {
        $tables = TableRestaurant::where('restaurant_id', $restaurant->id)
            ->where('status', 'available')
            ->get();

        $menus = $restaurant->menus;

        return view('orders.create', compact('restaurant', 'tables', 'menus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id' => 'required|exists:table_restaurants,id',
            'menu_items' => 'required|array',
            'menu_items.*.menu_id' => 'required|exists:menus,id',
            'menu_items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        // Calculate total amount
        $totalAmount = 0;
        foreach ($validatedData['menu_items'] as $item) {
            $menu = Menu::find($item['menu_id']);
            $totalAmount += $menu->price * $item['quantity'];
        }

        // Create order
        $order = Order::create([
            'customer_id' => Auth::id(),
            'restaurant_id' => $validatedData['restaurant_id'],
            'table_id' => $validatedData['table_id'],
            'order_date' => now(),
            'status' => 'pending',
            'total_amount' => $totalAmount,
            'notes' => $validatedData['notes'],
        ]);

        // Create order details
        foreach ($validatedData['menu_items'] as $item) {
            $menu = Menu::find($item['menu_id']);
            $order->orderDetails()->create([
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $menu->price,
                'subtotal' => $menu->price * $item['quantity']
            ]);
        }

        // Create payment
        $paymentResponse = $this->paymentService->createPayment($order);

        if ($paymentResponse['success']) {
            return redirect($paymentResponse['payment_url']);
        }

        return back()->with('error', 'Failed to process payment. Please try again.');
    }

    public function success(Request $request)
    {
        $order = Order::where('payment_token', $request->token)->firstOrFail();
        
        if ($order->payment_status === 'paid') {
            return view('orders.success', compact('order'));
        }

        return redirect()->route('orders.show', $order);
    }

    public function cancel(Request $request)
    {
        $order = Order::where('payment_token', $request->token)->firstOrFail();
        $order->update(['status' => 'cancelled']);

        return view('orders.cancelled', compact('order'));
    }
public function webhook(Request $request)
{
    // 🔹 Log seluruh payload ke laravel.log
    Log::info('📩 Webhook received', [
        'headers' => $request->headers->all(),
        'payload' => $request->all(),
    ]);

    // 🔹 Validasi signature webhook
    $signature = $request->header('X-Webhook-Signature');
    $webhookSecret = config('services.payment.webhook_secret');
    $payload = $request->all();
    $expectedSignature = hash_hmac('sha256', json_encode($payload), $webhookSecret);

    if (!hash_equals($expectedSignature, $signature)) {
        Log::warning('⚠️ Invalid webhook signature', [
            'expected' => $expectedSignature,
            'received' => $signature,
        ]);
        return response()->json(['error' => 'Invalid signature'], 401);
    }

    // ✅ Ambil event dan data
    $event = $request->input('event');
    $data = $request->input('data');

    Log::info('🔍 Webhook data parsed', [
        'event' => $event,
        'data' => $data,
    ]);

    $externalId = $data['external_id'] ?? null;
    $metadata = $data['metadata'] ?? [];
    $orderId = $metadata['order_id'] ?? null;

    Log::info('🧾 Extracted metadata', [
        'externalId' => $externalId,
        'metadata' => $metadata,
        'orderId' => $orderId,
    ]);

    $order = Order::find($orderId) ?? Order::where('order_id', $externalId)->first();

    if (!$order) {
        Log::warning('🚫 Order not found', [
            'external_id' => $externalId,
            'order_id' => $orderId,
        ]);
        return response()->json(['error' => 'Order not found'], 404);
    }

    // ✅ Cegah double processing
    if ($order->status === 'paid') {
        Log::info('🔁 Payment already processed', [
            'order_id' => $order->order_id,
        ]);
        return response()->json(['message' => 'Already processed'], 200);
    }

    // ✅ Tangani event sesuai status
    switch ($event) {
        case 'payment.success':
            $order->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'status' => 'completed',
            ]);

            Payment::where('order_id', $order->order_id)->update([
                'status' => 'completed',
                'payment_date' => now(),
            ]);

            Log::info('✅ Payment success processed', [
                'order_id' => $order->order_id,
                'amount' => $order->total_amount,
            ]);
            break;

        case 'payment.failed':
            $order->update(['payment_status' => 'failed']);
            Payment::where('order_id', $order->order_id)->update(['status' => 'failed']);
            Log::info('❌ Payment failed processed', ['order_id' => $order->order_id]);
            break;

        case 'payment.expired':
            $order->update(['payment_status' => 'expired']);
            Payment::where('order_id', $order->order_id)->update(['status' => 'failed']);
            Log::info('⌛ Payment expired processed', ['order_id' => $order->order_id]);
            break;

        default:
            Log::info('ℹ️ Unhandled event received', ['event' => $event]);
            return response()->json(['message' => 'Event not handled'], 200);
    }

    return response()->json(['message' => 'Webhook processed successfully'], 200);
}

}