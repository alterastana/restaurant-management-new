<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ManagerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\RestoranController;
use App\Http\Controllers\Dashboard\TableController;
use App\Http\Controllers\Dashboard\LoyaltyController;


Route::get('/', function () {
    return redirect('login');
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');


Route::prefix('dashboard')->name('Dashboard.')->group(function () {
    Route::resource('manager', ManagerController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('restoran', RestoranController::class);
    Route::resource('table', TableController::class);
    Route::resource('loyalty', LoyaltyController::class);
});

Route::get('/dashboard', function () {
    return view('Dashboard.manager.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
