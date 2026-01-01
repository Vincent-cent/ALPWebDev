<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserGameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GameDetailController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ImpediaController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\TipeItemController;
use App\Http\Controllers\Admin\MetodePembayaranController;
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

// Notifikasi Routes
Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])->name('notifikasi.index');
Route::get('/notifikasi/{notifikasi}', [App\Http\Controllers\NotifikasiController::class, 'show'])->name('notifikasi.show');

// Callback Routes
Route::post('/callback/saldo', [App\Http\Controllers\SaldoController::class, 'callback'])->name('saldo.callback');
Route::post('/callback/transaksi', [App\Http\Controllers\TransaksiController::class, 'callback'])->name('transaksi.callback');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
});

// Admin Routes
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminBannerController::class, 'dashboard'])->name('admin.dashboard');

    // Banner CRUD Routes
    Route::get('/admin/banners', [AdminBannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/admin/banners/create', [AdminBannerController::class, 'create'])->name('admin.banners.create');
    Route::post('/admin/banners', [AdminBannerController::class, 'store'])->name('admin.banners.store');
    Route::get('/admin/banners/{banner}/edit', [AdminBannerController::class, 'edit'])->name('admin.banners.edit');
    Route::put('/admin/banners/{banner}', [AdminBannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/admin/banners/{banner}', [AdminBannerController::class, 'destroy'])->name('admin.banners.destroy');

    // Game CRUD Routes
    Route::get('/admin/games', [AdminGameController::class, 'index'])->name('admin.games.index');
    Route::get('/admin/games/create', [AdminGameController::class, 'create'])->name('admin.games.create');
    Route::post('/admin/games', [AdminGameController::class, 'store'])->name('admin.games.store');
    Route::get('/admin/games/{game}/edit', [AdminGameController::class, 'edit'])->name('admin.games.edit');
    Route::put('/admin/games/{game}', [AdminGameController::class, 'update'])->name('admin.games.update');
    Route::delete('/admin/games/{game}', [AdminGameController::class, 'destroy'])->name('admin.games.destroy');

    // Item CRUD Routes
    Route::get('/admin/items', [AdminItemController::class, 'index'])->name('admin.items.index');
    Route::get('/admin/items/create', [AdminItemController::class, 'create'])->name('admin.items.create');
    Route::post('/admin/items', [AdminItemController::class, 'store'])->name('admin.items.store');
    Route::get('/admin/items/{item}/edit', [AdminItemController::class, 'edit'])->name('admin.items.edit');
    Route::put('/admin/items/{item}', [AdminItemController::class, 'update'])->name('admin.items.update');
    Route::delete('/admin/items/{item}', [AdminItemController::class, 'destroy'])->name('admin.items.destroy');

    // Tipe Item Routes
    Route::post('/admin/tipe-items', [TipeItemController::class, 'store'])->name('admin.tipe-items.store');
    Route::put('/admin/tipe-items/{id}', [TipeItemController::class, 'update'])->name('admin.tipe-items.update');
    Route::delete('/admin/tipe-items/{id}', [TipeItemController::class, 'destroy'])->name('admin.tipe-items.destroy');

    // Metode Pembayaran Routes
    Route::post('/admin/metode-pembayarans', [MetodePembayaranController::class, 'store'])->name('admin.metode-pembayarans.store');
    Route::put('/admin/metode-pembayarans/{id}', [MetodePembayaranController::class, 'update'])->name('admin.metode-pembayarans.update');
    Route::delete('/admin/metode-pembayarans/{id}', [MetodePembayaranController::class, 'destroy'])->name('admin.metode-pembayarans.destroy');
    
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


Route::get('/topup', function () {
    return view('topup');
});

Route::post('/order', [ImpediaController::class, 'order']);
