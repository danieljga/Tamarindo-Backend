<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/auth'

], function ($router) {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [\App\Http\Controllers\AuthController::class, 'me'])->name('me');
});

Route::apiResource('users', App\Http\Controllers\UserController::class)->middleware('api');
Route::apiResource('suppliers', App\Http\Controllers\SupplierController::class)->middleware('api');
Route::apiResource('products', App\Http\Controllers\ProductController::class)->middleware('api');
