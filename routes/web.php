<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\{
    ManagerController,
    CustomerController,
    MenuController,
    RestoranController,
    TableController, // Pastikan TableController di-import
    LoyaltyController
};
use Illuminate\Support\Facades\Auth;

// =====================================================
// 🔹 RUTE PUBLIK (tanpa login)
// =====================================================

// Halaman utama diarahkan ke welcome view
Route::get('/', function () {
    $menus = \App\Models\Menu::all();
    return view('welcome', ['menus' => $menus]);
});

// Public restaurants & menu (customer-facing)
Route::get('/restaurants', [App\Http\Controllers\LandingController::class, 'restaurants'])->name('landing.restaurants');
Route::get('/restaurants/{restoran}', [App\Http\Controllers\LandingController::class, 'show'])->name('landing.restoran.show');
Route::get('/menus', [App\Http\Controllers\LandingController::class, 'menus'])->name('landing.menus');
Route::get('/checkout', [App\Http\Controllers\LandingController::class, 'checkout'])->name('landing.checkout');
Route::post('/order', [App\Http\Controllers\LandingController::class, 'storeOrder'])->name('landing.order.store');

// Landing page utama
Route::get('/landing', fn() => view('landingpage.index'))
    ->name('landingpage.index');

// Halaman Menu (misal tombol "Pesan Sekarang")
Route::get('/menu', fn() => view('landingpage.menu'))
    ->name('landingpage.menu');

// Halaman login manual (bisa override bawaan Laravel Breeze/Jetstream)
Route::get('/login', fn() => view('auth.login'))
    ->name('login');

// =====================================================
// 🔹 RUTE OTENTIKASI (bawaan Laravel Breeze / Jetstream / Fortify)
// =====================================================
require __DIR__ . '/auth.php';

// =====================================================
// 🔹 RUTE DASHBOARD (memerlukan login & verifikasi email)
// =====================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // =================================================
    // 🔸 Dashboard utama (redirect sesuai role user)
    // =================================================
    Route::get('/dashboard', function () {
        $user = Auth::user();

        switch (true) {
            case $user->hasRole('admin'):
                return view('Dashboard.admin.dashboard');
            case $user->hasRole('manager'):
                return view('Dashboard.manager.dashboard');
            case $user->hasRole('customer'):
                // Show a lightweight customer dashboard (list of restaurants) inside dashboard layout
                return view('Dashboard.customer.dashboard');
            default:
                abort(403, 'Anda tidak memiliki peran yang valid.');
        }
    })->name('dashboard');

    // =================================================
    // 🔸 Grup rute dashboard (prefix: /dashboard)
    // =================================================
    Route::prefix('dashboard')->name('Dashboard.')->group(function () {

        // ------------------------------
        // 🔹 Rute hanya untuk Admin
        // ------------------------------
        Route::middleware('role:admin')->group(function () {
            Route::resource('users', ManagerController::class);
            Route::get('/manager', [ManagerController::class, 'index'])
                ->name('manager.index');
        });

        // ------------------------------
        // 🔹 Rute untuk Admin & Manager
        // ------------------------------
        Route::middleware('role:admin,manager')->group(function () {

            // ===================================================
            // 🔹 PENAMBAHAN RUTE KUSTOM UNTUK 'confirmDelete'
            // 🔹 Rute ini HARUS diletakkan SEBELUM `Route::resources`
            // ===================================================
            Route::get('table/{table}/delete', [TableController::class, 'confirmDelete'])
                 ->name('table.confirmDelete');


            // --- KODE ASLI ANDA (Tidak Dihapus) ---
            Route::resources([
                'restoran' => RestoranController::class,
                'customer' => CustomerController::class,
                'menu' => MenuController::class,
                'table' => TableController::class, // <-- 'table' tetap di sini
                'loyalty' => LoyaltyController::class,
            ]);
        });
    });

    // =================================================
    // 🔸 Profil Pengguna
    // =================================================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});