<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ManagerController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\RestoranController;
use App\Http\Controllers\Dashboard\TableController;
use App\Http\Controllers\Dashboard\LoyaltyController;

// ---------------------------------------------------------
// Rute awal: arahkan langsung ke halaman login
// ---------------------------------------------------------
Route::get('/', function () {
    return redirect()->route('login');
});

// ---------------------------------------------------------
// Alias untuk /dashboard (agar tidak error di redirect())
// ---------------------------------------------------------
Route::get('/dashboard', function () {
    return redirect()->route('Dashboard.index');
})->name('dashboard');

// ---------------------------------------------------------
// Grup utama Dashboard
// ---------------------------------------------------------
Route::prefix('dashboard')
    ->middleware(['auth', 'verified'])
    ->name('Dashboard.')
    ->group(function () {

        // Halaman utama dashboard (Manager view)
        Route::get('/', function () {
            return view('Dashboard.manager.dashboard');
        })->name('index');

        // ------------------------------
        // CRUD Controller untuk fitur-fitur dashboard
        // ------------------------------
        Route::resource('manager', ManagerController::class);
        Route::resource('customer', CustomerController::class);
        Route::resource('menu', MenuController::class);
        Route::resource('restoran', RestoranController::class);
        Route::resource('table', TableController::class);
        Route::resource('loyalty', LoyaltyController::class);
    });

// ---------------------------------------------------------
// Grup untuk profil pengguna login
// ---------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------------------------------------------
// Route bawaan Laravel Auth
// ---------------------------------------------------------
require __DIR__ . '/auth.php';
