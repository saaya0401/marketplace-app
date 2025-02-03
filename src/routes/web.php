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
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/profile', [UserController::class, 'profileStore']);
});
Route::get('/item/{itemId}', [ItemController::class, 'detail']);