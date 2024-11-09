<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    //--product
    Route::get('/dashboard_overview', [ProductController::class, 'dashboard_overview']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/product/{slug}', [ProductController::class, 'edit']);
    Route::patch('/product/{slug}', [ProductController::class, 'update']);
    Route::delete('/product/delete/{slug}', [ProductController::class, 'delete']);
});





Route::post('/register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
