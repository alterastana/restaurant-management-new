<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Restoran; // Model Restoran
use App\Models\TableRestaurant;
use Illuminate\Http\Request;
use App\Services\PaymentGatewayService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Controller ini menangani Order, mencakup alur publik (store, webhook) 
 * dan alur manajemen (index, show).
 */
class OrderController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentGatewayService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    // =========================================================================
    // MANAGEMENT FLOW (DASHBOARD)
    // =========================================================================

    /**
     * Menampilkan daftar semua order untuk manajemen (Dashboard).
     */
    public function index()
    {
        $orders = Order::with(['customer', 'table'])
            ->latest()
            ->paginate(10); 

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail order spesifik untuk manajemen (Dashboard).
     */
    public function show(Order $order)
    {
        // Tambahkan reservation agar bisa tampil di show.blade.php
        $order->load('orderDetails.menu', 'customer', 'table', 'payment', 'reservation');

        return view('orders.show', compact('order'));
    }

    /**
     * Menampilkan form untuk membuat order secara manual (opsional, jika diperlukan di sisi admin).
     */
    public function create(Restoran $restoran)
    {
        $tables = TableRestaurant::where('restoran_id', $restoran->id)
            ->where('status', 'available')
            ->get();

        $menus = $restoran->menus;

        return view('orders.create', compact('restoran', 'tables', 'menus'));
    }

    /**
     * Mengubah status order (misalnya dari 'processing' ke 'ready' atau 'completed')
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,ready,completed,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        // Jika status diubah menjadi "completed" atau "cancelled", kembalikan status meja
        if (in_array($validated['status'], ['completed', 'cancelled']) && $order->table) {
            $order->table->update(['status' => 'available']);
        }
        
        return back()->with('success', "Status Order #{$order->id} berhasil diperbarui menjadi {$validated['status']}.");
    }

    /**
     * Menghapus order (biasanya hanya untuk data testing/bersih-bersih)
     */
    public function destroy(Order $order)
    {
        // Pastikan order bisa dihapus (misalnya, hanya order yang dibatalkan/failed)
        if ($order->payment_status !== 'paid') {
            $order->delete();
            return back()->with('success', "Order #{$order->id} berhasil dihapus.");
        }
        
        return back()->with('error', "Order yang sudah dibayar tidak dapat dihapus.");
    }

    // =========================================================================
    // PUBLIC FLOW (TRANSACTION)
    // =========================================================================

    /**
     * Menyimpan order baru, menghitung total, dan menginisiasi pembayaran.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'restoran_id' => 'required|exists:restorans,id',
            'table_id' => 'required|exists:table_restaurants,id',
            'menu_items' => 'required|array',
            'menu_items.*.menu_id' => 'required|exists:menus,id',
            'menu_items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            // Hitung total amount
            $totalAmount = 0;
            $menuItemsData = [];

            $menuIds = collect($validatedData['menu_items'])->pluck('menu_id')->unique()->toArray();
            $menus = Menu::whereIn('id', $menuIds)->get()->keyBy('id');

            foreach ($validatedData['menu_items'] as $item) {
                $menu = $menus->get($item['menu_id']);
                if ($menu) {
                    $subtotal = $menu->price * $item['quantity'];
                    $totalAmount += $subtotal;
                    $menuItemsData[] = [
                        'menu_id' => $item['menu_id'],
                        'quantity' => $item['quantity'],
                        'price' => $menu->price,
                    ];
                }
            }
            
            // Buat Order
            $order = Order::create([
                'customer_id' => Auth::id() ?? 1,
                'restoran_id' => $validatedData['restoran_id'],
                'table_id' => $validatedData['table_id'],
                'order_date' => now(),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'total_amount' => $totalAmount,
                'notes' => $validatedData['notes'],
            ]);

            // Buat Order Details
            foreach ($menuItemsData as $item) {
                $order->orderDetails()->create($item);
            }

            // Inisiasi Pembayaran melalui Service
            $paymentResponse = $this->paymentService->createPayment($order);

            if (!$paymentResponse['success']) {
                throw new \Exception('Gagal membuat link pembayaran: ' . ($paymentResponse['message'] ?? 'Unknown error.'));
            }
            
            // Simpan Payment Token dan Update Status Meja
            $order->update([
                'payment_token' => $paymentResponse['token'] ?? null,
            ]);

            TableRestaurant::where('id', $validatedData['table_id'])->update(['status' => 'occupied']);

            DB::commit();

            return redirect($paymentResponse['payment_url']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Gagal memproses order dan pembayaran. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Halaman sukses pembayaran
     */
    public function success(Request $request)
    {
        $order = Order::where('payment_token', $request->token)->firstOrFail();
        
        if ($order->payment_status === 'paid') {
            return view('orders.success', compact('order'));
        }
        
        return view('orders.pending', compact('order'))->with('warning', 'Pembayaran sedang diproses, mohon tunggu sebentar.'); 
    }

    /**
     * Halaman pembatalan pembayaran
     */
    public function cancel(Request $request)
    {
        $order = Order::where('payment_token', $request->token)->firstOrFail();
        
        if ($order->payment_status === 'unpaid') {
            DB::beginTransaction();
            try {
                $order->update(['status' => 'cancelled', 'payment_status' => 'failed']);
                
                if ($order->table) {
                    $order->table->update(['status' => 'available']);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Order cancellation failed: ' . $e->getMessage());
            }
        }

        return view('orders.cancelled', compact('order'));
    }

    /**
     * Endpoint webhook Payment Gateway
     */
    public function webhook(Request $request)
    {
        Log::info('📩 Webhook received', ['payload' => $request->all()]);

        $signature = $request->header('X-Webhook-Signature');
        $webhookSecret = config('services.payment.webhook_secret'); 
        $payload = $request->getContent();

        $data = $request->json()->all();
        $event = $data['event'] ?? $data['status'] ?? null;
        $transactionData = $data['data'] ?? $data;

        $externalId = $transactionData['external_id'] ?? $transactionData['reference'] ?? null; 
        
        if (!$externalId) {
            Log::warning('🚫 External ID missing in webhook payload.');
            return response()->json(['error' => 'External ID missing'], 400);
        }

        $order = Order::where('payment_token', $externalId)->first();

        if (!$order) {
            Log::warning('🚫 Order not found for payment_token: ' . $externalId);
            return response()->json(['error' => 'Order not found'], 404);
        }

        DB::beginTransaction();
        try {
            if ($order->payment_status === 'paid') { 
                DB::commit();
                return response()->json(['message' => 'Already processed'], 200);
            }

            switch (strtolower($event)) {
                case 'paid':
                case 'payment.success':
                case 'invoice.paid': 
                    $order->update([
                        'payment_status' => 'paid',
                        'paid_at' => now(),
                        'status' => 'processing',
                    ]);

                    Payment::updateOrCreate(
                        ['order_id' => $order->id],
                        [
                            'payment_method' => $transactionData['payment_method'] ?? 'Unknown',
                            'status' => 'completed',
                            'payment_date' => now(),
                            'amount' => $order->total_amount,
                        ]
                    );

                    Log::info('✅ Payment success processed', ['order_id' => $order->id]);
                    break;

                case 'failed':
                case 'payment.failed':
                case 'invoice.expired':
                    $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
                    Payment::updateOrCreate(['order_id' => $order->id], ['status' => 'failed']);
                    
                    if ($order->table) {
                        $order->table->update(['status' => 'available']);
                    }

                    Log::info('❌ Payment failed/expired processed', ['order_id' => $order->id]);
                    break;

                default:
                    Log::info('ℹ️ Unhandled event received', ['event' => $event]);
                    break;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Webhook processing failed: ' . $e->getMessage(), ['order_id' => $order->id]);
            return response()->json(['error' => 'Internal server error'], 500);
        }

        return response()->json(['message' => 'Webhook processed successfully'], 200);
    }
}
