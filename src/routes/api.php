<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\ExternalProductController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Product routes for all users
    Route::apiResource('products', ProductController::class);
    // Route::get('/product_list', [ProductController::class, 'index']);
    Route::get('/my-products', [ProductController::class, 'myProducts']);

    Route::post('/products/add', [ExternalProductController::class, 'addProduct'])
        ->name('api.products.add');
    // Admin only routes
    Route::middleware('admin')->group(function () {
        // Admin routes
        Route::get('/users', [AdminController::class, 'usersWithProducts'])->name('admin.users');
        Route::get('/admin/products', [AdminController::class, 'allProducts']);
        Route::delete('/admin/products/{product}', [AdminController::class, 'deleteProduct']);

        // External product integration
        Route::prefix('external-products')->group(function () {
            Route::get('/', [ExternalProductController::class, 'index']);
            Route::post('/add', [ExternalProductController::class, 'addProduct']);
            Route::post('/switch-api', [ExternalProductController::class, 'switchApi']);
        });
    });
});
