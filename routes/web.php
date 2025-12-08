<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/topup', function () {
    return view('topup');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/', function () {
    return view('beranda');
})->name('beranda');

Route::post('/order', [App\Http\Controllers\TopupController::class, 'createOrder'] );

// Route::get('/beranda', function () {
//     return view('beranda');
// })->middleware(['auth', 'verified'])->name('beranda');



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
