<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;
use App\Models\TableRestaurant;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentGatewayService $paymentService)
    {
        $this->middleware('auth');
        $this->paymentService = $paymentService;
    }

    public function create(Restaurant $restaurant)
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
        $result = $this->paymentService->handleWebhook($request->all());

        if (!$result) {
            return response()->json(['message' => 'Failed to process webhook'], 400);
        }

        return response()->json(['message' => 'Webhook processed successfully']);
    }
}