<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\TableRestaurant;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    // ======================================================
    // 🔹 3. Tampilkan semua menu (halaman publik + table number)
    // ======================================================
    public function menus(Request $request)
    {
        // Ambil nomor meja dari query string (?table=6)
        $tableNumber = $request->query('table', 1); // default meja 1
        session(['table_number' => $tableNumber]);

        // Ambil kapasitas meja langsung dari database



        //dd($tableNumber, $capacity);

        $menus = Menu::all();


        // Kirim kapasitas langsung ke view
        return view('landing.menu', compact('menus', 'tableNumber'));
    }



    // ======================================================
    // 🔹 4. Tampilkan form checkout
    // ======================================================
    public function checkout()
    {
        // dd(session('cart'));
        return view('landing.checkout');
    }

    // ======================================================
    // 🔹 5. Simpan data sementara sebelum konfirmasi
    // ======================================================
    public function previewOrder(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Simpan sementara data order ke session
        session(['order_data' => $validated]);
        session('table_number', []);

        // Ambil cart dari session
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('landing.menus')->with('error', 'Keranjang Anda masih kosong.');
        }

        return view('landing.orderconfirm', [
            'order' => $validated,
            'cart'  => $cart,
        ]);
    }

    // ======================================================
    // 🔹 6. Simpan data ke database setelah konfirmasi
    // ======================================================
    public function storeOrder(Request $request)
    {
        $data = session('order_data');
        $cart = session('cart', []);


        if (!$data) {
            return redirect()->route('landing.checkout')
                ->with('error', 'Data pesanan tidak ditemukan. Silakan isi kembali.');
        }

        if (empty($cart)) {
            return redirect()->route('landing.menus')
                ->with('error', 'Keranjang kosong. Silakan pilih menu terlebih dahulu.');
        }

        // Cek apakah customer sudah ada
        $customer = Customer::firstOrCreate(
            ['phone' => $data['phone']],
            $data
        );

        // Simpan customer ke session
        session(['checkout_customer' => $customer]);
        session()->forget('order_data');



        // Arahkan ke halaman pembayaran
        return redirect()->route('payment.confirm')
            ->with('success', 'Pesanan atas nama ' . $customer->name . ' berhasil disimpan dan meja ' . $tableNumber . ' sudah dipesan.');
    }

    // ======================================================
    // 🔹 7. Simpan cart ke session (AJAX)
    // ======================================================
    public function saveCartSession(Request $request)
    {
        $cartData = $request->all();
        session(['cart' => $cartData]);
        return response()->json(['status' => 'ok']);
    }

    // ======================================================
    // 🔹 8. Halaman utama (Welcome Page)
    // ======================================================
    public function welcome(Request $request)
    {
        // Ambil nomor meja dari query (misalnya ?table=6)
        $tableNumber = $request->query('table', 1);
        session(['table_number' => $tableNumber]);
        $capacity = TableRestaurant::where('table_number', intval($tableNumber))->value('capacity');

        // Reset session cart & customer setiap ke halaman utama
        session()->forget(['cart', 'checkout_customer']);

        $menus = Menu::all();
        return view('welcome', compact('menus', 'tableNumber', 'capacity'));
    }

    public function success()
    {
        return view('landing.payment.success');
    }
}
