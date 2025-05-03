<?php

use Illuminate\Support\Facades\Route;
// use App\Models\Product;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/about', [App\Http\Controllers\AboutController::class, 'about'])->name('about'); 

Route::post('/user/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('user.register');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [App\Http\Controllers\CategoriesController::class, 'show'])->name('categories.show');

// Public Product Routes
Route::get('/products', [App\Http\Controllers\ProductsController::class, 'index'])->name('products.index');
Route::get('/products/search', [App\Http\Controllers\ProductsController::class, 'search'])->name('products.search');
Route::get('/products/{product:slug}', [App\Http\Controllers\ProductsController::class, 'show'])->name('products.show');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/update-quantity', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.update-quantity');
Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');

Route::get('/orders', [App\Http\Controllers\OrdersController::class, 'index'])->name('orders.index');

Route::get('/address', [App\Http\Controllers\AddressController::class, 'index'])->name('address');
Route::post('/address/store', [App\Http\Controllers\AddressController::class, 'store'])->name('address.store');
Route::post('/address/update', [App\Http\Controllers\AddressController::class, 'update'])->name('address.update');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/store', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

Auth::routes();

Route::get('/resources', function () {
    return view('resources');
})->name('resources');

// Include admin routes
require __DIR__.'/admin.php';