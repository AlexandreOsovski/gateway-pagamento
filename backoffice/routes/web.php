<?php

use App\Http\Controllers\{
    Authentication\LoginController,
    Authentication\RegisterController,

    Dashboard\DashboardController,
    Dashboard\FinanceController,
    Dashboard\ProfileController,
    Dashboard\KeysApiController,
};
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;


#SITE
Route::get('/', [LoginController::class, 'index'])->name('login.get');
Route::get('/register', [RegisterController::class, 'index'])->name('register.get');


Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::middleware(['auth.client'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,  'index'])->name('dashboard.get');
    Route::get('/finance', [FinanceController::class,  'index'])->name('finance.get');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.get');
    Route::get('/keys-api', [KeysApiController::class, 'index'])->name('keysapi.get');

    Route::post('/keys-api-post', [KeysApiController::class, 'store'])->name('keysapi.post');

    Route::put('/alter-data', [ProfileController::class, 'update'])->name('alterdata.put');

    Route::delete('/logout', [LoginController::class, 'logout'])->name('logout');
});