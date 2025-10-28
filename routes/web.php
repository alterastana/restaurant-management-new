<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ManagerController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\RestoranController;
use App\Http\Controllers\Dashboard\TableController;
use App\Http\Controllers\Dashboard\LoyaltyController;
use Illuminate\Support\Facades\Auth;

// ======================================================================
// 🔹 Rute Publik
// ======================================================================

// Halaman utama diarahkan ke landing page
Route::get('/', function () {
    return redirect()->route('landingpage.index');
});

// Landing page utama
Route::get('/landing', function () {
    return view('landingpage.index');
})->name('landingpage.index');

// Halaman Menu (dari tombol "Pesan Sekarang")
Route::get('/menu', function () {
    return view('landingpage.menu');
})->name('landingpage.menu');

// Halaman login manual (jika ingin override bawaan)
Route::get('/login', function () {
    return view('auth.login');
});

// ======================================================================
// 🔹 Rute Otentikasi (Laravel Breeze/Fortify/Jetstream)
// ======================================================================
require __DIR__.'/auth.php';

// ======================================================================
// 🔹 Rute Dashboard (memerlukan login)
// ======================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard utama dinamis berdasarkan role
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return view('Dashboard.admin.dashboard');
        }
        if ($user->hasRole('manager')) {
            return view('Dashboard.manager.dashboard');
        }
        if ($user->hasRole('customer')) {
            return view('Dashboard.customer.index');
        }

        abort(403, 'Anda tidak memiliki peran yang valid.');
    })->name('dashboard');

    // Grup rute dashboard
    Route::prefix('dashboard')->name('Dashboard.')->group(function () {
        
        // Hanya Admin
        Route::middleware('role:admin')->group(function() {
            Route::resource('users', ManagerController::class);
            Route::get('/manager', [ManagerController::class, 'index'])
                ->name('manager.index');
        });

        // Admin & Manager
        Route::middleware('role:admin,manager')->group(function() {
            Route::resource('restoran', RestoranController::class);
            Route::resource('customer', CustomerController::class);
            Route::resource('menu', MenuController::class);
            Route::resource('table', TableController::class);
            Route::resource('loyalty', LoyaltyController::class);
        });
    });

    // Profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
