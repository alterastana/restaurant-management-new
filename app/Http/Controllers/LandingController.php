<?php

namespace App\Http\Controllers;

use App\Models\Restoran;
use App\Models\Menu;
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
}
