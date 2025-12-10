<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Dashboard\{
    ManagerController,
    CustomerController,
    MenuController,
    RestoranController,
    TableController,
    LoyaltyController,
    ReservationController // ← ditambahkan
};
use App\Http\Controllers\OrderController; // Controller tunggal untuk Order (publik dan dashboard)
use Illuminate\Support\Facades\Auth;

// =====================================================
// 🔹 RUTE PUBLIK (tanpa login)
// =====================================================

// Halaman utama (welcome view)
Route::get('/', function () {
    $menus = \App\Models\Menu::all();
    return view('welcome', ['menus' => $menus]);
})->name('landing.welcome');

// Public restaurants & menu (customer-facing)
Route::get('/restaurants', [LandingController::class, 'restaurants'])->name('landing.restaurants');
Route::get('/restaurants/{restoran}', [LandingController::class, 'show'])->name('landing.restoran.show');
Route::get('/menus', [LandingController::class, 'menus'])->name('landing.menus');

// Landing page utama
Route::get('/landing', [LandingController::class, 'index']) 
    ->name('landingpage.index');

// Halaman Menu
Route::get('/menu', [LandingController::class, 'menu'])
    ->name('landingpage.menu');

Route::post('/save-cart-session', [LandingController::class, 'saveCartSession'])->name('landing.saveCartSession');
Route::get('/checkout', [LandingController::class, 'checkout'])->name('landing.checkout');

// Order Flow
// simpan sementara di session
Route::post('/order/preview', [LandingController::class, 'previewOrder'])->name('landing.order.preview');

// simpan ke database setelah konfirmasi
Route::post('/order', [LandingController::class, 'storeOrder'])->name('landing.order.store');
Route::get('/order/success', [LandingController::class, 'success'])->name('landing.order.success');

// Halaman login manual (bisa override bawaan Laravel Breeze/Jetstream)
Route::get('/login', fn() => view('auth.login'))->name('login');

// Payment Gateway (publik)
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/waiting', [PaymentController::class, 'waiting'])->name('payment.waiting');

// Webhook (Tidak memerlukan auth) - Menggunakan OrderController
Route::post('/webhook/payment', [OrderController::class, 'webhook'])->name('webhook.payment');

// =====================================================
// 🔹 RUTE OTENTIKASI
// =====================================================
require __DIR__ . '/auth.php';

// =====================================================
// 🔹 RUTE DASHBOARD (memerlukan login & verifikasi email)
// =====================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // 🔸 Dashboard utama (redirect sesuai role user)
    Route::get('/dashboard', function () {
        $user = Auth::user();

        switch (true) {
            case $user->hasRole('admin'):
                return view('Dashboard.admin.dashboard');
            case $user->hasRole('manager'):
            case $user->hasRole('kasir'): // Menyatukan kasir ke view manager
                return view('Dashboard.manager.dashboard');
            case $user->hasRole('customer'):
                return view('Dashboard.customer.dashboard');
            default:
                abort(403, 'Anda tidak memiliki peran yang valid.');
        }
    })->name('dashboard');

    // 🔸 Grup rute dashboard (prefix: /dashboard, name: Dashboard.)
    Route::prefix('dashboard')->name('Dashboard.')->group(function () {

        // ------------------------------
        // 🔹 Rute hanya untuk Admin
        // ------------------------------
        Route::middleware('role:admin')->group(function () {
            Route::resource('users', ManagerController::class);
            Route::get('/manager', [ManagerController::class, 'index'])->name('manager.index');
        });

        // ------------------------------
        // 🔹 Rute untuk Admin, Manager, & Kasir (Operasional)
        // ------------------------------
        Route::middleware('role:admin,manager,kasir')->group(function () {

            // Rute Kustom harus di atas resources (contoh: table.confirmDelete)
            Route::get('table/{table}/delete', [TableController::class, 'confirmDelete'])->name('table.confirmDelete');

            // KONSOLIDASI SEMUA RESOURCE ROUTES DI SINI
            Route::resources([
                'restoran' => RestoranController::class,
                'customer' => CustomerController::class,
                'menu' => MenuController::class,
                'table' => TableController::class, 
                'loyalty' => LoyaltyController::class,
                'reservation' => ReservationController::class,
                'order' => OrderController::class, 
            ]);

            // 🔹 Route dashboard untuk Payments (read-only)
            Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
            Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        });
    });

    // 🔸 Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
