<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Public routes
Route::get('/', [ProductController::class, 'publicIndex'])->name('home');
Route::get('/products', [ProductController::class, 'publicIndex'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart routes (available for everyone)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/{product}', [CartController::class, 'remove'])->name('cart.remove');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('/products', ProductController::class)->except(['show']);
    });

// Customer routes that require authentication
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});

Auth::routes();
