<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Services\Pix;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/pix', [Pix::class, 'createTransactionPix']);
Route::post('/webhook-pix', [Pix::class, 'webHook']);
Route::post('/pay-pix-in-admin', [Pix::class, 'createTransferPix']);