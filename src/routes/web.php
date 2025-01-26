<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/', [ItemController::class, 'index']);
Route::middleware('auth')->group(function (){
    Route::post('/logout', [UserController::class, 'logout']);
});