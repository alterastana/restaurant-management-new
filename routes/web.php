<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\ManagerController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\RestoranController;
use App\Http\Controllers\Dashboard\TableController;
use App\Http\Controllers\Dashboard\LoyaltyController;
use Illuminate\Support\Facades\Auth;

// ======================================================================
// 🔹 Authentication Routes
// ======================================================================
require __DIR__.'/auth.php';

// ======================================================================
// 🔹 Public Routes
// ======================================================================
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/landing', function () {
    return view('landingpage.index');
})->name('landingpage.index');

Route::get('/menu', function () {
    return view('landingpage.menu');
})->name('landingpage.menu');

// ======================================================================
// 🔹 Protected Routes (Requires Authentication)
// ======================================================================
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard routing based on role
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
        
        abort(403, 'Invalid user role.');
    })->name('dashboard');

    // Dashboard Routes Group
    Route::prefix('dashboard')->name('Dashboard.')->group(function () {
        // Admin Only Routes
        Route::middleware('role:admin')->group(function() {
            Route::resource('users', ManagerController::class);
            Route::get('/manager', [ManagerController::class, 'index'])->name('manager.index');
        });

        // Admin & Manager Routes
        Route::middleware('role:admin,manager')->group(function() {
            Route::resource('restoran', RestoranController::class);
            Route::resource('customer', CustomerController::class);
            Route::resource('menu', MenuController::class);
            Route::resource('table', TableController::class);
            Route::resource('loyalty', LoyaltyController::class);
        });
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});