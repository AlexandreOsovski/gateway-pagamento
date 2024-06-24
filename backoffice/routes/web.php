<?php

use App\Http\Controllers\{
    Authentication\LoginController,
    Authentication\RegisterController,

    Dashboard\DashboardController,
    Dashboard\FinanceController,
    Dashboard\ProfileController,
    Dashboard\KeysApiController,
    Dashboard\NotificationController,
    Dashboard\TransferUserToUser,
    Dashboard\TransactionDetail,
    Dashboard\SupportController,
};

use Illuminate\Support\Facades\Route;


#SITE
Route::get('/', [LoginController::class, 'index'])->name('login.get');
Route::get('/register', [RegisterController::class, 'index'])->name('register.get');


Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::middleware(['auth.client'])->group(function () {
    #GET
    Route::get('/dashboard', [DashboardController::class,  'index'])->name('dashboard.get');
    Route::get('/finance', [FinanceController::class,  'index'])->name('finance.get');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.get');
    Route::get('/keys-api', [KeysApiController::class, 'index'])->name('keysapi.get');
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.get');
    Route::get('/transaction-detail', [TransactionDetail::class, 'index'])->name('transaction.get');
    Route::get('/support', [SupportController::class, 'index'])->name('support.get');
    #POST
    Route::post('/keys-api-post', [KeysApiController::class, 'store'])->name('keysapi.post');
    Route::post('/transfer-user-to-user', [TransferUserToUser::class, 'transfer'])->name('transferUserToUser.post');
    Route::post('/support-post', [SupportController::class, 'store'])->name('support.post');
    #PUT
    Route::put('/alter-data', [ProfileController::class, 'update'])->name('alterdata.put');
    Route::put('/read-notification', [NotificationController::class, 'readNotification'])->name('notification.put');

    #DELETE
    Route::delete('/notification-delete', [NotificationController::class, 'delete'])->name('notification.delete');
    Route::delete('/logout', [LoginController::class, 'logout'])->name('logout');
});
