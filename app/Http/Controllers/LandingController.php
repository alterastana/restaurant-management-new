<?php

namespace App\Http\Controllers;

use App\Models\Restoran;
use App\Models\Menu;
use App\Models\Customer;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    // List restaurants (public)
    public function restaurants()
    {
        $restorans = Restoran::orderBy('name')->get();
        return view('landing.restaurants', compact('restorans'));
    }

    // Show single restaurant and its menu
    public function show(Restoran $restoran)
    {
        $menus = Menu::where('restaurant_id', $restoran->restaurant_id)->get();
        return view('landing.restoran', compact('restoran', 'menus'));
    }

    // Show all menus
    public function menus()
    {
        $menus = Menu::all();
        return view('landing.menu', compact('menus'));
    }

    // Show checkout form
    public function checkout()
    {
        return view('landing.checkout');
    }

    // Store the order
    public function storeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $customer = Customer::create($request->all());

        // Di sini Anda bisa menambahkan logika untuk membuat pesanan (order)
        // yang terhubung dengan customer yang baru dibuat.
        // Untuk saat ini, kita hanya akan redirect ke halaman sukses.

        return redirect('/')->with('success', 'Order placed successfully!');
    }
}
