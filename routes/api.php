<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopupController;

Route::post('/callback/reseller', [TopupController::class, 'resellerCallback']);
