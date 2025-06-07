<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;

Route::post('/register', [UserController::class, 'register']);
Route::get('/email/verify/{id}', [UserController::class, 'emailVerifyView']);
Route::middleware(['signed'])->get('/email/verify/{id}/{hash}', [UserController::class, 'emailVerify'])->name('verification.verify');
Route::post('/email/verification-notification', [UserController::class, 'emailNotification']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/', [ItemController::class, 'index']);
Route::get('/item/search', [ItemController::class, 'search']);
Route::middleware('auth')->group(function (){
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/mypage/profile', [UserController::class, 'profile']);
    Route::post('/mypage/profile', [UserController::class, 'profileStore']);
    Route::patch('/mypage/profile', [UserController::class, 'profileUpdate']);
    Route::get('/mypage', [ItemController::class, 'mypage']);
    Route::get('/sell', [ItemController::class, 'sellView']);
    Route::post('/sell', [ItemController::class, 'sell']);
    Route::post('/transaction/message', [TransactionController::class, 'message']);
    Route::get('/purchase/{itemId}', [ItemController::class, 'purchaseView']);
    Route::post('/purchase/{itemId}/stripe', [PaymentController::class, 'purchaseStripe']);
    Route::get('/success', [PaymentController::class, 'success']);
    Route::get('/cancel', [PaymentController::class, 'cancel']);
    Route::get('/purchase/address/{itemId}', [UserController::class, 'address']);
    Route::patch('/purchase/address/{itemId}', [UserController::class, 'addressUpdate']);
    Route::post('/comment/{itemId}', [ItemController::class, 'comment']);
    Route::post('/mylist/{itemId}', [ItemController::class, 'mylist']);
    Route::get('/transaction/{itemId}', [TransactionController::class, 'chatView']);
    Route::patch('/message/edit/{itemId}', [TransactionController::class, 'messageEdit']);
    Route::delete('/message/delete/{itemId}', [TransactionController::class, 'messageDelete']);
});
Route::get('/item/{itemId}', [ItemController::class, 'detail']);