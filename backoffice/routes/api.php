<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Services\Pix;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Api\XpayPixApi,
    Api\XpayCreditCardApi,
    Api\CreditCartApi,
    Api\AuthenticateApi,
};


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/authenticate', [AuthenticateApi::class, 'authenticateUser']);

    Route::prefix('pix')->group(function () {
        Route::post('/make', [XpayPixApi::class, 'createTransactionPix']);
        Route::post('/status', [XpayPixApi::class, 'statusTransactionPix']);
        Route::post('/webhook', [XpayPixApi::class, 'webHook']);
    });

    Route::prefix('credit')->group(function () {
        // Route::post('/make', [XpayCreditCardApi::class, 'chargePayment']);
        // Route::post('/cancel', [XpayCreditCardApi::class, 'cancelCharge']);
        // Route::post('/summary', [XpayCreditCardApi::class, 'getSummaryTransaction']);
    });

    // Route::post('/pay-pix-in-admin', [Pix::class, 'createTransferPix']);
    Route::post('/webhook-pix', [Pix::class, 'webHook']);
});
