<?php

namespace App\Http\Controllers;

use App\Models\Restoran;
use App\Models\Menu;
use App\Models\Customer;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    // ======================================================
    // 🔹 1. Tampilkan daftar restoran
    // ======================================================
    public function restaurants()
    {
        $restorans = Restoran::orderBy('name')->get();
        return view('landing.restaurants', compact('restorans'));
    }

    // ======================================================
    // 🔹 2. Tampilkan restoran tertentu beserta menunya
    // ======================================================
    public function show(Restoran $restoran)
    {
        $menus = Menu::where('restaurant_id', $restoran->restaurant_id)->get();
        return view('landing.restoran', compact('restoran', 'menus'));
    }

    // ======================================================
    // 🔹 3. Tampilkan semua menu (halaman publik)
    // ======================================================
    public function menus()
    {
        $menus = Menu::all();
        return view('landing.menu', compact('menus'));
    }

    // ======================================================
    // 🔹 4. Tampilkan form checkout
    // ======================================================
    public function checkout()
    {
        return view('landing.checkout');
    }

    // ======================================================
    // 🔹 5. Simpan data sementara (belum masuk DB)
    // ======================================================
public function previewOrder(Request $request)
{
    $validated = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'required|string|max:20',
    ]);

    // Simpan sementara data order ke session
    session(['order_data' => $validated]);

    // ✅ Ambil data cart dari session (disimpan sebelumnya dari frontend)
    $cart = session('cart', []);

    // Tampilkan halaman konfirmasi dengan data order dan cart
    return view('landing.orderconfirm', [
        'order' => $validated,
        'cart' => $cart,
    ]);
}


    // ======================================================
    // 🔹 6. Simpan data ke database setelah dikonfirmasi
    // ======================================================
    public function storeOrder(Request $request)
    {
        // Ambil data dari session
        $data = session('order_data');

        if (!$data) {
            return redirect()->route('landing.checkout')
                             ->with('error', 'Data pesanan tidak ditemukan. Silakan isi kembali.');
        }

        // Simpan ke database (baru disini)
        $customer = Customer::create($data);

        // Hapus session setelah disimpan
        session()->forget('order_data');

        // Redirect ke halaman sukses
        return redirect('/')
            ->with('success', 'Pesanan berhasil dibuat atas nama ' . $customer->name . '!');
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
    public function welcome()
    {
        // Reset session cart setiap kali kembali ke halaman utama
        session()->forget('cart');
        session()->forget('checkout_customer');

        // ✅ Ambil semua menu dari database
        $menus = Menu::all();

        // Kirim data ke view
        return view('welcome', compact('menus'));
    }
}
