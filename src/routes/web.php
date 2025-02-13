<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/', [ItemController::class, 'index']);
Route::get('item/search', [ItemController::class, 'search']);
Route::middleware('auth')->group(function (){
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/mypage/profile', [UserController::class, 'profile']);
    Route::post('/mypage/profile', [UserController::class, 'profileStore']);
    Route::patch('/mypage/profile', [UserController::class, 'profileUpdate']);
    Route::get('/mypage', [ItemController::class, 'mypage']);
    Route::get('/sell', [ItemController::class, 'sellView']);
    Route::post('/sell', [ItemController::class, 'sell']);
    Route::get('/purchase/{itemId}', [ItemController::class, 'purchaseView']);
    Route::post('purchase/{itemId}', [ItemController::class, 'purchase']);
    Route::get('/purchase/address/{itemId}', [UserController::class, 'address']);
    Route::patch('/purchase/address/{itemId}', [UserController::class, 'addressUpdate']);
    Route::post('/comment/{itemId}', [ItemController::class, 'comment']);
    Route::post('/mylist/{itemId}', [ItemController::class, 'mylist']);
});
Route::get('/item/{itemId}', [ItemController::class, 'detail']);