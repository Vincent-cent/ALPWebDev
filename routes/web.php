<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('topup');
});


Route::post('/order', [App\Http\Controllers\TopupController::class, 'createOrder']);

