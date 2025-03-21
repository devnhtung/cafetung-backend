<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\SocialAuthController;

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login/zalo', [SocialAuthController::class, 'redirectToZalo'])->name('login.zalo');
Route::get('/login/zalo/callback', [SocialAuthController::class, 'handleZaloCallback']);
