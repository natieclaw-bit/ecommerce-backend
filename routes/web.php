<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminInventoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

Route::middleware('admin.auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard']);

    Route::get('/admin/products', [AdminProductController::class, 'index']);
    Route::get('/admin/products/create', [AdminProductController::class, 'create']);
    Route::post('/admin/products', [AdminProductController::class, 'store']);
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit']);
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update']);
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy']);

    Route::get('/admin/inventory', [AdminInventoryController::class, 'index']);
    Route::get('/admin/inventory/{inventory}/edit', [AdminInventoryController::class, 'edit']);
    Route::put('/admin/inventory/{inventory}', [AdminInventoryController::class, 'update']);

    Route::get('/admin/orders', [AdminOrderController::class, 'index']);
    Route::put('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus']);
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
