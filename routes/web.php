<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserGameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GameDetailController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\GameTransactionController;
use App\Http\Controllers\LacakPesananController;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/lacak-pesanan', [LacakPesananController::class, 'index'])->name('lacak-pesanan');
Route::post('/lacak-pesanan', [LacakPesananController::class, 'track'])->name('lacak-pesanan.track');

Route::post('/order', [App\Http\Controllers\TopUpController::class, 'order']);

Route::get('/game/{id}', [GameDetailController::class, 'show'])->name('game.detail');
Route::post('/promo/verify', [GameDetailController::class, 'verifyPromo'])->name('promo.verify');

// Transaction Routes (accessible by both authenticated users and guests)
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
Route::get('/transaksi/{id}/success', [TransaksiController::class, 'success'])->name('transaksi.success');
Route::get('/transaksi/{id}/debug', [TransaksiController::class, 'debug'])->name('transaksi.debug');

// Game Transaction to APIGames
Route::post('/game/send-to-apigames', [GameTransactionController::class, 'sendToAPIGames'])->name('game.send-to-apigames');

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

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Promo Codes
    Route::resource('promo-codes', App\Http\Controllers\Admin\PromoCodeController::class);

    // Banner Promos
    Route::resource('banners', App\Http\Controllers\Admin\BannerPromoController::class);

    // Promo Notifications
    Route::resource('promo-notifikasi', App\Http\Controllers\Admin\PromoNotifikasiController::class);

    // Transactions
    Route::resource('transaksi', App\Http\Controllers\Admin\TransaksiController::class);

    // Payment Methods
    Route::resource('metode-pembayarans', App\Http\Controllers\Admin\MetodePembayaranController::class);

    // Games
    Route::resource('games', App\Http\Controllers\Admin\GameController::class);

    // Items
    Route::resource('items', App\Http\Controllers\Admin\ItemController::class);

    // Tipe Items
    Route::resource('tipe-items', App\Http\Controllers\Admin\TipeItemController::class);
});

require __DIR__ . '/auth.php';


Route::get('/topup', function () {
    return view('topup');
});

Route::post('/order', [TopUpController::class, 'order']);

//Route::post('/order', [ImpediaController::class, 'order']);
