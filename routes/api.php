<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('admins')->group(function () {
    Route::post('register', [AdminController::class, 'register']);
    Route::post('login', [AdminController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('admins')->group(function () {
        Route::get('profile', [AdminController::class, 'profile']);
        Route::put('profile', [AdminController::class, 'updateProfile']);
        Route::post('logout', [AdminController::class, 'logout']);
        Route::delete('delete', [AdminController::class, 'delete']);
        Route::get('', [AdminController::class, 'index']);
    });

    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('employees/leave', LeaveController::class);
});
