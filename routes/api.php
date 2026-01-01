<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\GameTransactionController;

Route::post('/callback/reseller', [TopupController::class, 'resellerCallback']);
Route::post('/callback/game-transaction', [GameTransactionController::class, 'apiGamesCallback']);
