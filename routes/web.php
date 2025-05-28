<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\VouchersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware(['cache'])->group(function () {
    Auth::routes();
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('shop', [HomeController::class, 'shop'])->name('home.shop');


Route::get('info', [HomeController::class, 'info_customer'])->name('home.info')->middleware('auth', 'cache');
Route::get('aonam/{id}', [HomeController::class, 'show'])->name('home.show');
Route::get('cart', [CartController::class, 'index'])->name('home.cart');
Route::get('checkout', [OrderController::class, 'index'])->name('home.checkout');
Route::get('done', [OrderController::class, 'done'])->name('home.done');
Route::get('dashboard', [HomeController::class, 'admin']);

Route::resource('products', ProductsController::class);
Route::resource('categories', CategoriesController::class);

// Login google
Route::get('/auth/redirect/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/callback/google', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

//admin voucher

Route::prefix('dashboard')->group(function () {
    Route::get('/voucher/{id}', [VouchersController::class, 'show'])->name('dashboard.voucher');
    Route::post('voucher/add_voucher', [VouchersController::class, 'store']);
    Route::get('voucher/{action}/{id}', [VouchersController::class, 'detail']);
    Route::get('voucher/{action}/{id}/edit', [VouchersController::class, 'edit']);
    Route::post('voucher/{id}/update', [VouchersController::class, 'update']);
    Route::post('voucher/ads', [VouchersController::class, 'ads']);
    Route::post('voucher/disable/{id}', [VouchersController::class, 'disable']);
    Route::post('voucher/active/{id}', [VouchersController::class, 'active']);

});
