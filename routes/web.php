<?php


use Illuminate\Support\Facades\Route;


Route::prefix('payment')->group(function () {
    Route::get('/initialize/{payment_attempt_id}', [App\Http\Controllers\API\PaymentController::class, 'initialize'])->name('payment.initialize');
    Route::get('/callback/{payment_attempt_id}', [App\Http\Controllers\API\PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/response', function(){  echo request()->input('type');  })->name('payment.response');
});







