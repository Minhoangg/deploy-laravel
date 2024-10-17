<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\payment\PaymentController;

Route::prefix('payment')->group(function () {
    Route::post('/createPayment', [PaymentController::class, 'createPaymentHandle'])->middleware('auth.jwt');
});

Route::post('/paymentHook', [PaymentController::class, 'createPaymentHandle'])->middleware('auth.jwt');
