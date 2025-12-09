<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameDetailController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BerandaController;

Route::get('/', [BerandaController::class, 'index'])->name('beranda');


Route::get('/topup', function () {
    return view('topup');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/order', [App\Http\Controllers\TopupController::class, 'createOrder'] );

// Route::get('/beranda', function () {
//     return view('beranda');
// })->middleware(['auth', 'verified'])->name('beranda');

Route::get('/game/{id}', [GameDetailController::class, 'show'])->name('game.detail');
Route::post('/promo/verify', [GameDetailController::class, 'verifyPromo'])->name('promo.verify');

// Transaction Routes
Route::middleware('auth')->group(function () {
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profile Portal Routes
    Route::get('/profile/dashboard', function () {
        return view('portal.user.profile.profile');
    })->name('profile.show');
    
    Route::get('/profile/history', function () {
        return view('portal.user.profile.history');
    })->name('profile.history');
    
    Route::get('/profile/saldo-topup', function () {
        return view('portal.user.profile.saldo-topup');
    })->name('profile.saldo-topup');
});

require __DIR__.'/auth.php';
