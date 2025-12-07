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
use Illuminate\Support\Str;
use Stringable;

use function Symfony\Component\Clock\now;

class PaymentController extends Controller
{
    public function process(Request $request)
    {
        // 🔹 Ambil data dari session
        $orderData = session('order_data');
        $cart = session('cart');

        if (empty($orderData) || empty($cart)) {
            return redirect()->route('landing.checkout')->with('error', 'Data pesanan tidak ditemukan.');
        }

        // 🔹 Ambil atau buat data customer
        $customer = Customer::firstOrCreate(
            ['email' => $orderData['email']],
            [
                'name'  => $orderData['name'],
                'phone' => $orderData['phone']
            ]
        );

        // 🔹 Buat reservasi otomatis berdasarkan nomor meja
        $tableNumber = session('table_number', 1); // default meja 1
        $table = TableRestaurant::where('table_number', $tableNumber)->first();

        $reservation = null;

        if ($table) {
            $reservation = Reservation::create([
                'table_id'          => $table->table_id,
                'customer_id'       => $customer->customer_id,
                'reservation_date'  => now(),
                'reservation_time'  => now(),

            ]);
        }

        // dd($cart);
        // 🔹 Hitung total harga pesanan
        $totalAmount = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        // dd($totalAmount);

        // 🔹 Cek stok setiap produk
        foreach ($cart as $item) {
            $product = Menu::find($item['menu_id']);
            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('landing.menu')
                    ->with('error', 'Stok produk "' . $item['name'] . '" tidak mencukupi.');
            }
        }

        $expiredHours = (int) config('services.payment.expired_hours', 24);

        // 🔹 Simpan order ke database
        $order = Order::create([
            'customer_id'     => $customer->customer_id,
            'restaurant_id'   => 1,
            'reservation_id'  => $reservation?->reservation_id, // <- pakai id reservasi yang baru dibuat
            'order_type'      => $request->order_type,
            'order_date'      => now(),
            'status'          => 'pending',
            'total_amount'    => $totalAmount,
            'notes'           => $request->input('note'),
            'status'  => 'pending',
            'payment_method'  => 'virtual_account',
        ]);

        // 🔹 Simpan detail order items (jika relasi tersedia)
        if (method_exists($order, 'orderDetails')) {
            Log::info('cart', $cart);
            foreach ($cart as $item) {
                $product = Menu::find($item['menu_id']);
                Log::info('product', $product->toArray());
                if ($product) {
                    $order->orderDetails()->create([
                        'menu_id' => $product->menu_id,
                        'quantity'   => $item['quantity'],
                        'price'      => $product->price,

                    ]);

                    // Kurangi stok produk
                    $product->decrement('stock', $item['quantity']);
                }
            }
        }

        // 🔹 Buat Virtual Account Pembayaran
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.payment.api_key'),
                'Accept'    => 'application/json',
            ])->post(config('services.payment.base_url') . '/virtual-account/create', [
                'external_id'      => (string) $order->order_id,
                'amount'           => $order->total_amount,
                'customer_name'    => $customer->name,
                'customer_email'   => $customer->email,
                'customer_phone'   => $customer->phone,
                'description'      => 'Pembayaran pesanan #' . $order->order_id,
                'expired_duration' => $expiredHours,
                'callback_url'     => route('landing.order.success'),
                'metadata' => [
                    'order_id'    => $order->order_id,
                    'customer_id' => $order->customer_id,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $order->update([
                    'payment_token' => $data['data']['va_number'] ?? null,
                ]);

                $paymentTransaction = Payment::create([
                    'order_id' => $order->order_id,
                    'reservation_id' => $reservation?->reservation_id,
                    'payment_method' => $data['data']['payment_method'] ?? 'virtual_account',
                    'amount' => $data['data']['amount'] ?? $order->total_amount,
                    'payment_date' => $data['data']['payment_date'] ?? now(),
                    'status' => $data['data']['status'] ?? 'pending',
                    'payment_url' => $data['data']['payment_url'] ?? null,
                ]);

                session(['payment' => [
                    'order'     => $order->toArray(),
                    'cart'      => $cart,
                    'total'     => $totalAmount,
                    'va_number' => $data['data']['va_number'] ?? null,
                    'name'      => $customer->name,
                    'payment_url' => $data['data']['payment_url'] ?? null
                ]]);

                return redirect()->route('payment.waiting');
            } else {
                $order->update(['status' => 'failed']);
                Log ::error('Gagal membuat pembayaran: ' . $response->body());
                return redirect()->route('landing.menu')->with('error', 'Gagal membuat pembayaran. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            $order->update(['status' => 'failed']);
            Log::error('Gagal membuat pembayaran: ' . $e->getMessage());
            return redirect()->route('landing.welcome')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    public function waiting()
    {
        $payment = session('payment');

        if (empty($payment)) {
            return redirect()->route('landing.checkout')->with('error', 'Tidak ada data pembayaran.');
        }

        return view('landing.payment.waiting', compact('payment'));
    }
}
