<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/stats', [Admin\DashboardController::class, 'index']);

    Route::get('/users', [Admin\UserController::class, 'apiIndex']);
    Route::put('/users/{user}', [Admin\UserController::class, 'apiUpdate']);
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy']);

    Route::get('/categories', [Admin\CategoryController::class, 'apiIndex']);
    Route::put('/categories/{category}', [Admin\CategoryController::class, 'apiUpdate']);
    Route::delete('/categories/{category}', [Admin\CategoryController::class, 'destroy']);

    Route::get('/packages', [Admin\PackageController::class, 'apiIndex']);
    Route::put('/packages/{package}', [Admin\PackageController::class, 'apiUpdate']);
    Route::delete('/packages/{package}', [Admin\PackageController::class, 'destroy']);

    Route::get('/enrollments', [Admin\EnrollmentController::class, 'apiIndex']);
    Route::put('/enrollments/{enrollment}', [Admin\EnrollmentController::class, 'apiUpdate']);
});
