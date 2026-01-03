<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserGameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GameDetailController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LacakPesananController;
use App\Http\Controllers\ImpediaController;
use App\Http\Controllers\Admin\GameController as AdminGameController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\TipeItemController;
use App\Http\Controllers\Admin\MetodePembayaranController;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/lacak-pesanan', [LacakPesananController::class, 'index'])->name('lacak-pesanan');
Route::post('/lacak-pesanan', [LacakPesananController::class, 'track'])->name('lacak-pesanan.track');

Route::post('/order', [App\Http\Controllers\TopUpController::class, 'order']);

Route::get('/game/{id}', [GameDetailController::class, 'show'])->name('game.detail');
Route::post('/promo/verify', [GameDetailController::class, 'verifyPromo'])->name('promo.verify');
Route::post('/game/send-to-apigames', [App\Http\Controllers\GameTransactionController::class, 'sendToAPIGames'])->name('game.send-to-apigames');

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

// Profile Portal Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile/dashboard', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    Route::get('/profile/saldo-topup', function () {
        return view('portal.user.profile.saldo-topup');
    })->name('profile.saldo-topup');
    
    // Admin profile edit
    Route::get('/profile/admin/admin-editprofile', [ProfileController::class, 'editAdmin'])->name('profile.admin.admin-editprofile');

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

    // Game CRUD Routes
    Route::get('/games', [AdminGameController::class, 'index'])->name('games.index');
    Route::get('/games/create', [AdminGameController::class, 'create'])->name('games.create');
    Route::post('/games', [AdminGameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [AdminGameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [AdminGameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [AdminGameController::class, 'destroy'])->name('games.destroy');
    Route::post('/games/{game}/items', [AdminGameController::class, 'addItem'])->name('games.addItem');
    Route::put('/games/{game}/items/{item}/quantity', [AdminGameController::class, 'updateItemQuantity'])->name('games.updateItemQuantity');
    Route::delete('/games/{game}/items/{item}', [AdminGameController::class, 'removeItem'])->name('games.removeItem');

    // Item CRUD Routes
    Route::get('/items', [AdminItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [AdminItemController::class, 'create'])->name('items.create');
    Route::post('/items', [AdminItemController::class, 'store'])->name('items.store');
    Route::get('/items/{item}/edit', [AdminItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [AdminItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [AdminItemController::class, 'destroy'])->name('items.destroy');

    // Tipe Item Routes
    Route::post('/tipe-items', [TipeItemController::class, 'store'])->name('tipe-items.store');
    Route::put('/tipe-items/{id}', [TipeItemController::class, 'update'])->name('tipe-items.update');
    Route::delete('/tipe-items/{id}', [TipeItemController::class, 'destroy'])->name('tipe-items.destroy');
});

require __DIR__.'/auth.php';


Route::get('/topup', function () {
    return view('topup');
});

Route::post('/order', [ImpediaController::class, 'order']);
