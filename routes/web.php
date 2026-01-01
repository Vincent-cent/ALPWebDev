<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserGameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameDetailController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LacakPesananController;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');


Route::get('/topup', function () {
    return view('topup');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/lacak-pesanan', [LacakPesananController::class, 'index'])->name('lacak-pesanan');
Route::post('/lacak-pesanan', [LacakPesananController::class, 'track'])->name('lacak-pesanan.track');

Route::post('/order', [App\Http\Controllers\TopupController::class, 'createOrder'] );

Route::get('/game/{id}', [GameDetailController::class, 'show'])->name('game.detail');
Route::post('/promo/verify', [GameDetailController::class, 'verifyPromo'])->name('promo.verify');

// Transaction Routes (accessible by both authenticated users and guests)
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
Route::get('/transaksi/{id}/success', [TransaksiController::class, 'success'])->name('transaksi.success');
Route::get('/transaksi/{id}/debug', [TransaksiController::class, 'debug'])->name('transaksi.debug');

// Saldo Routes
Route::middleware('auth')->group(function () {
    Route::post('/saldo/topup', [App\Http\Controllers\SaldoController::class, 'topup'])->name('saldo.topup');
    Route::get('/saldo/payment/{id}', [App\Http\Controllers\SaldoController::class, 'payment'])->name('saldo.payment');
    Route::get('/saldo/success/{id}', [App\Http\Controllers\SaldoController::class, 'success'])->name('saldo.success');
});

// Callback Routes
Route::post('/callback/saldo', [App\Http\Controllers\SaldoController::class, 'callback'])->name('saldo.callback');
Route::post('/callback/transaksi', [App\Http\Controllers\TransaksiController::class, 'callback'])->name('transaksi.callback');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profile Portal Routes
    Route::get('/profile/dashboard', [ProfileController::class, 'show'])->name('profile.show');
    
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    
    Route::get('/profile/saldo-topup', function () {
        return view('portal.user.profile.saldo-topup');
    })->name('profile.saldo-topup');

    // UserGame CRUD Routes
    Route::get('/profile/game/create', [UserGameController::class, 'create'])->name('usergame.create');
    Route::post('/profile/game', [UserGameController::class, 'store'])->name('usergame.store');
    Route::get('/profile/game/{userGame}/edit', [UserGameController::class, 'edit'])->name('usergame.edit');
    Route::put('/profile/game/{userGame}', [UserGameController::class, 'update'])->name('usergame.update');
    Route::delete('/profile/game/{userGame}', [UserGameController::class, 'destroy'])->name('usergame.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Promo Codes
    Route::resource('promo-codes', App\Http\Controllers\Admin\PromoCodeController::class);
    
    // Banner Promos
    Route::resource('banner-promos', App\Http\Controllers\Admin\BannerPromoController::class);
    
    // Promo Notifications
    Route::resource('promo-notifikasi', App\Http\Controllers\Admin\PromoNotifikasiController::class);
    
    // Transactions
    Route::resource('transaksi', App\Http\Controllers\Admin\TransaksiController::class);
    
    // Payment Methods
    Route::resource('metode-pembayarans', App\Http\Controllers\Admin\MetodePembayaranController::class);
});

require __DIR__.'/auth.php';
