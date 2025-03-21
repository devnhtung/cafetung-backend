<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCategoryController;
// use App\Http\Controllers\Auth\ZaloAuthController;
use App\Http\Controllers\SocialAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('sliders', SliderController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('post-categories', PostCategoryController::class);
});
Route::get('/sliders', [SliderController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
// Route::get('/auth/zalo', [ZaloAuthController::class, 'redirectToZalo']);
// Route::get('/auth/zalo/callback', [ZaloAuthController::class, 'handleZaloCallback']);
Route::get('/auth/zalo', [SocialAuthController::class, 'redirectToZalo']);
Route::get('/auth/zalo/callback', [SocialAuthController::class, 'handleZaloCallback']);
