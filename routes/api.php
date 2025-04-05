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
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\ShiftTypeController;
use App\Http\Controllers\ShiftRegistrationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeEvaluationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PositionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    // Route::apiResource('sliders', SliderController::class);
    Route::post('orders', [OrderController::class, 'store']);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('post-categories', PostCategoryController::class);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/shift-registrations', [ShiftRegistrationController::class, 'store']);
    Route::get('/shift-registrations/pending', [ShiftRegistrationController::class, 'pending']);
    Route::patch('/shift-registrations/{id}/approve', [ShiftRegistrationController::class, 'approve']);
    Route::patch('/shift-registrations/{id}/reject', [ShiftRegistrationController::class, 'reject']);
    Route::patch('/shift-registrations/{id}/check-in', [ShiftRegistrationController::class, 'checkIn']);
    Route::patch('/shift-registrations/{id}/check-out', [ShiftRegistrationController::class, 'checkOut']);
    Route::post('/shift-registrations/{id}/tasks', [ShiftRegistrationController::class, 'addTask']);
    Route::patch('/shift-registrations/{id}/tasks/{taskId}/complete', [ShiftRegistrationController::class, 'completeTask']);
    Route::delete('/shift-registrations/{id}/tasks/{taskId}', [ShiftRegistrationController::class, 'deleteTask']);
    Route::get('/employees/details', [EmployeeController::class, 'details']);
    Route::get('/employee-evaluations', [EmployeeEvaluationController::class, 'index']);
    Route::post('/employee-evaluations', [EmployeeEvaluationController::class, 'store']);
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/shifts', [ShiftController::class, 'index']);
    Route::post('/shifts', [ShiftController::class, 'store']);

    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']); // Tạo user
    Route::put('/employees/{id}', [EmployeeController::class, 'updateUser']); // Cập nhật user
    Route::post('/employee-details', [EmployeeController::class, 'storeDetail']); // Tạo employee_detail
    Route::put('/employee-details/{id}', [EmployeeController::class, 'updateDetail']); // Cập nhật employee_detail
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
});
Route::get('/employee-details', [EmployeeController::class, 'getDetails']);
Route::get('/shift-types', [ShiftTypeController::class, 'index']);
Route::get('/shift-types/{id}/tasks', [ShiftTypeController::class, 'getTasks']);
Route::get('/positions', [PositionController::class, 'index']);
Route::get('/positions/{id}/tasks', [PositionController::class, 'getTasks']);
Route::get('/shift-registrations/{id}/tasks', [ShiftRegistrationController::class, 'getTasks']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/sliders', [SliderController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);
