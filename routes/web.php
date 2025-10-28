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

// Rute utama akan diarahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rute-rute di dalam grup ini memerlukan login dan email terverifikasi
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute dashboard utama yang dinamis
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

    // Rute-rute lain di dalam dashboard
    Route::prefix('dashboard')->name('Dashboard.')->group(function () {
        
        // Rute HANYA untuk Admin
        Route::middleware('role:admin')->group(function() {
            Route::resource('users', ManagerController::class);
            Route::get('/manager', [ManagerController::class, 'index'])
                ->name('manager.index');
        });

        // Rute untuk Admin & Manager
        Route::middleware('role:admin,manager')->group(function() {
            Route::resource('restoran', RestoranController::class);
            Route::resource('customer', CustomerController::class);
            Route::resource('menu', MenuController::class);
            Route::resource('table', TableController::class);
            
            // =======================================================
            // PINDAHKAN RUTE LOYALTY KE SINI AGAR SESUAI HAK AKSES
            // =======================================================
            Route::resource('loyalty', LoyaltyController::class);
        });

    });

    // Rute untuk profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Memuat rute-rute autentikasi bawaan Laravel
require __DIR__.'/auth.php';