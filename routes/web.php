<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth', RoleMiddleware::class . ':admin'])
    ->prefix('admin')
    ->as('admin.') // <- This adds name prefix
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('/products', ProductController::class);
    });


// Customer routes (authentication & role check required)
Route::middleware(['auth', RoleMiddleware::class . ':customer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // View cart
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add'); // Add product to cart
    Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove'); // Remove product from cart
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index'); // Checkout page
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process'); // Process payment
});

// Public routes (no authentication needed for browsing products)
Route::get('/', [ProductController::class, 'index'])->name('products.index'); // Show products

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');