<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\SocialAuthController;

Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::get('/', function () {
    return redirect()->route('filament.admin.pages.dashboard');
});

// Trang React cho người dùng
Route::get('/user/profile', function () {
    return view('layouts.react', [
        'title' => 'Thông tin cá nhân',
        'pageComponent' => 'resources/js/pages/UserProfile.jsx',
    ]);
});
