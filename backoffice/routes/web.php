<?php

use App\Http\Controllers\{
    Authentication\LoginController,
    Dashboard\DashboardController,
    Authentication\RegisterController,
};

use Illuminate\Support\Facades\Route;


#SITE
Route::get('/', [LoginController::class, 'index'])->name('login.get');
Route::get('/register', [RegisterController::class, 'index'])->name('register.get');


Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::middleware(['auth.client'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,  'index'])->name('dashboard.get');
    Route::delete('/logout', [LoginController::class, 'logout'])->name('logout');
});
