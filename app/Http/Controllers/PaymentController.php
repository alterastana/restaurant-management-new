<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\TableRestaurant;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // ===========================
    // Process Payment (Frontend)
    // ===========================
    public function process(Request $request)
    {
        $orderData = session('order_data');
        $cart = session('cart');

        if (empty($orderData) || empty($cart)) {
            return redirect()->route('landing.checkout')->with('error', 'Data pesanan tidak ditemukan.');
        }

        DB::beginTransaction();

        try {
            // ===========================
            // 1️⃣ Customer
            // ===========================
            $customer = Customer::firstOrCreate(
                ['phone' => $orderData['phone']],
                ['name' => $orderData['name'], 'email' => $orderData['email']]
            );

            // ===========================
            // 2️⃣ Reservation (optional)
            // ===========================
            $tableNumber = session('table_number', 1);
            $table = TableRestaurant::where('table_number', $tableNumber)->first();

            $reservation = null;
            if ($table) {
                $reservation = Reservation::create([
                    'table_id' => $table->id,
                    'customer_id' => $customer->id,
                    'reservation_date' => now()->toDateString(),
                    'reservation_time' => now()->toTimeString(),
                    'status' => 'pending_order',
                ]);
            }

            // ===========================
            // 3️⃣ Hitung total & cek stok
            // ===========================
            $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            foreach ($cart as $item) {
                $product = Menu::find($item['menu_id']);
                if (!$product || $product->stock < $item['quantity']) {
                    DB::rollBack();
                    return redirect()->route('landing.menu')
                        ->with('error', 'Stok produk "' . $item['name'] . '" tidak mencukupi.');
                }
            }

            $expiredHours = (int) config('services.payment.expired_hours', 24);

            // ===========================
            // 4️⃣ Buat Order
            // ===========================
            $order = Order::create([
                'customer_id' => $customer->id,
                'restaurant_id' => 1,
                'reservation_id' => $reservation?->id,
                'order_type' => $request->order_type,
                'order_date' => now(),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'notes' => $request->input('note'),
                'payment_method' => 'virtual_account',
            ]);

            // ===========================
            // 5️⃣ Order Details & kurangi stok
            // ===========================
            if (method_exists($order, 'orderDetails')) {
                foreach ($cart as $item) {
                    $product = Menu::find($item['menu_id']);
                    if ($product) {
                        $order->orderDetails()->create([
                            'menu_id' => $product->id,
                            'quantity' => $item['quantity'],
                            'price' => $product->price,
                        ]);
                        $product->decrement('stock', $item['quantity']);
                    }
                }
            }

            // ===========================
            // 6️⃣ Payment Gateway
            // ===========================
            $response = Http::withHeaders([
                'X-API-Key' => config('services.payment.api_key'),
                'Accept' => 'application/json',
            ])->post(config('services.payment.base_url') . '/virtual-account/create', [
                'external_id' => (string) $order->id,
                'amount' => $order->total_amount,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone,
                'description' => 'Pembayaran pesanan #' . $order->id,
                'expired_duration' => $expiredHours,
                'callback_url' => route('landing.order.success'),
                'metadata' => [
                    'order_id' => $order->id,
                    'customer_id' => $order->customer_id,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $responseData = $data['data'] ?? [];

                $order->update([
                    'payment_token' => $responseData['va_number'] ?? null,
                ]);

                // Simpan Payment
                Payment::create([
                    'order_id' => $order->id,
                    'reservation_id' => $reservation?->id,
                    'payment_method' => $responseData['payment_method'] ?? 'virtual_account',
                    'amount' => $responseData['amount'] ?? $order->total_amount,
                    'status' => $responseData['status'] ?? 'pending',
                    'payment_url' => $responseData['payment_url'] ?? null,
                ]);

                // ===========================
                // 7️⃣ Simpan session payment
                // ===========================
                $sessionData = [
                    'order_id' => $order->id,
                    'total' => $totalAmount,
                    'va_number' => $responseData['va_number'] ?? null,
                    'name' => $customer->name,
                    'payment_url' => $responseData['payment_url'] ?? null,
                    'expiry_time' => now()->addHours($expiredHours)->toDateTimeString(),
                    'cart' => $cart, // penting agar view waiting bisa akses daftar pesanan
                ];

                session(['payment' => $sessionData]);

                // Hapus session yang lain
                session()->forget(['order_data', 'table_number']);

                Log::debug('PAYMENT_CONTROLLER: Session data set successfully.', ['session_data' => $sessionData]);

                DB::commit();

                return redirect()->route('payment.waiting');
            } else {
                DB::rollBack();
                Log::error('PAYMENT_CONTROLLER: Gagal membuat pembayaran ke Payment Gateway: ' . $response->body());
                return redirect()->route('landing.menu')->with('error', 'Gagal membuat pembayaran. Silakan coba lagi. Error PG: ' . ($response->json()['message'] ?? 'Unknown Error'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('PAYMENT_CONTROLLER: Gagal memproses order dan pembayaran: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('landing.welcome')->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // ===========================
    // Waiting Page
    // ===========================
    public function waiting()
    {
        $payment = session('payment');

        if (empty($payment)) {
            Log::error('PAYMENT_CONTROLLER: Session data "payment" HILANG. Redirect ke home.');
            return redirect()->route('landing.welcome')->with('error', 'Sesi pembayaran hilang. Harap coba order kembali.');
        }

        Log::debug('PAYMENT_CONTROLLER: Session data "payment" ditemukan.', ['payment_data' => $payment]);

        return view('landing.payment.waiting', compact('payment'));
    }

    // ===========================
    // DASHBOARD / ADMIN METHODS
    // ===========================

    // Index semua payment untuk dashboard
    public function index()
    {
        $payments = Payment::with(['order', 'reservation'])->orderBy('created_at', 'desc')->paginate(15);
        return view('Dashboard.payments.index', compact('payments'));
    }

    // Show detail payment untuk dashboard
    public function show(Payment $payment)
    {
        $payment->load(['order.customer', 'reservation.customer']);
        return view('Dashboard.payments.show', compact('payment'));
    }
}
