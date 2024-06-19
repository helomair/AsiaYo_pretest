<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('currency')->group(function () {
    Route::get('/exchange', [CurrencyController::class, 'exchange'])->name('currency.exchange');
});