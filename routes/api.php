<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Categorycontroller;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/dashboard_overview', [ProductController::class, 'dashboard_overview']);
    //--product
    Route::post('/product', [ProductController::class, 'store']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/get/products', [ProductController::class, 'getProducts']);
    Route::get('/product/{slug}', [ProductController::class, 'edit']);
    Route::patch('/product/{slug}', [ProductController::class, 'update']);
    Route::delete('/product/delete/{slug}', [ProductController::class, 'delete']);

    //--category ---
    Route::apiResource('category', Categorycontroller::class);

    //-- sale --
    Route::get('/sales', [SaleController::class, 'index']);
    Route::post('/sale', [SaleController::class, 'store']);

});





Route::post('/register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/storage-link', function () {
    Artisan::call('storage:link');

    dd('Storage Link Success');
});
