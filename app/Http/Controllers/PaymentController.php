<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Stringable;

class PaymentController extends Controller
{
public function process(Request $request)
{
    // Ambil data dari session
    $orderData = session('order_data');
    $cart = session('cart');



    if (empty($orderData) || empty($cart)) {
        return redirect()->route('landing.checkout')->with('error', 'Data pesanan tidak ditemukan.');
    }

    // Hitung total harga
    $totalAmount = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

    // Cek stok produk sebelum lanjut
    foreach ($cart as $item) {
        $product = Menu::find($item['menu_id']);
        if (!$product || $product->stock < $item['quantity']) {
            return redirect()->route('landing.menu')->with('error', 'Stok produk "' . $item['name'] . '" tidak mencukupi.');
        }
    }

    $expiredHours = (int) config('services.payment.expired_hours', 24);

    // Simpan order ke database
    $order = Order::create([
        'customer_id'     => $orderData['customer_id'] ?? null,
        'restaurant_id'   => 1,
        'reservation_id'  => $orderData['reservation_id'] ?? null,
        'order_type'      => $orderData['order_type'] ?? 'dine-in',
        'order_date'      => now(),
        'status'          => 'pending',
        'total_amount'    => $totalAmount,
        'notes'           => $orderData['notes'] ?? null,
        'payment_status'  => 'pending',
        'payment_method'  => 'virtual_account',
    ]);

    // Simpan detail produk (jika ada tabel order_items)
    if (method_exists($order, 'items')) {
        foreach ($cart as $item) {
            $product = Menu::find($item['menu_id']);
            if ($product) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                    'subtotal'   => $product->price * $item['quantity'],
                ]);

                // Kurangi stok produk
                $product->decrement('stock', $item['quantity']);
            }
        }
    }

    // === Proses Pembuatan Virtual Account ===
    try {
        $response = Http::withHeaders([
            'X-API-Key' => config('services.payment.api_key'),
            'Accept'    => 'application/json',
        ])->post(config('services.payment.base_url') . '/virtual-account/create', [
            'external_id'      => (string) Str::uuid(),
            'amount'           => $order->total_amount,
            'customer_name'    => $orderData['customer_name'] ?? 'Pelanggan',
            'customer_email'   => $orderData['customer_email'] ?? 'noemail@example.com',
            'customer_phone'   => $orderData['customer_phone'] ?? '081234567890',
            'description'      => 'Pembayaran pesanan #' . $order->order_id,
            'expired_duration' => $expiredHours,
            'callback_url'     => route('orders.success', $order->order_id),
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

            // Simpan data pembayaran ke session untuk halaman waiting
            session([
                'payment' => [
                    'order'     => $order->toArray(),
                    'cart'      => $cart,
                    'total'     => $totalAmount,
                    'va_number' => $data['data']['va_number'] ?? null,
                ]
            ]);

            return redirect()->route('payment.waiting');
        } else {
            $order->update(['payment_status' => 'failed']);
            return redirect()->route('landing.menu')->with('error', 'Gagal membuat pembayaran. Silakan coba lagi.');
        }
    } catch (\Exception $e) {
        $order->update(['payment_status' => 'failed']);
        return redirect()->route('landing.menu')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
