<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductVariantsController;
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
    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);
    Route::get('variants', [ProductVariantsController::class, 'index'])->name('variants.index');



    Route::prefix('products/{productId}')->group(function () {
        // Hiển thị form tạo biến thể mới
        Route::get('variants/create', [ProductVariantsController::class, 'create'])->name('variants.create');
        // Xử lý lưu biến thể mới
        Route::post('variants', [ProductVariantsController::class, 'store'])->name('variants.store');
        // Hiển thị form chỉnh sửa biến thể
        Route::get('variants/{variantId}/edit', [ProductVariantsController::class, 'edit'])->name('variants.edit');
        // Xử lý cập nhật biến thể
        Route::put('variants/{variantId}/update', [ProductVariantsController::class, 'update'])->name('variants.update');
        // Xóa biến thể (nếu cần, có thể dùng POST thay vì DELETE)
        Route::delete('variants/{variantId}/delete', [ProductVariantsController::class, 'destroy'])->name('variants.destroy');
        // Hiển thị chi tiết biến thể
        Route::get('variants/{variantId}', [ProductVariantsController::class, 'show'])->name('variants.show');
    });
});
