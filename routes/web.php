<?php

use App\Http\Controllers\Auth\ChangepasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageProductVariantsController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductVariantsController;
use App\Http\Controllers\SizeController;
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



// Xác thực tài khoản

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');


// Chatbot

Route::post('/chat', [ChatBotController::class, 'reply']);
// Login google
Route::get('/auth/redirect/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/callback/google', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

// client voucher
Route::post('accept_voucher/{id}', [VouchersController::class, 'accept_voucher'])->middleware('auth');





Route::prefix('dashboard')->group(function () {
    Route::get('/voucher/{id}', [VouchersController::class, 'show'])->name('dashboard.voucher');
    Route::post('voucher/add_voucher', [VouchersController::class, 'store']);
    Route::get('voucher/{action}/{id}', [VouchersController::class, 'detail']);
    Route::get('voucher/{action}/{id}/edit', [VouchersController::class, 'edit']);
    Route::post('voucher/{id}/update', [VouchersController::class, 'update']);
    Route::post('voucher/ads', [VouchersController::class, 'ads'])->middleware('throttle:5,1');
    Route::post('voucher/disable/{id}', [VouchersController::class, 'disable']);
    Route::post('voucher/active/{id}', [VouchersController::class, 'active']);
    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);
    // Tạo biến thể: cần productId
    Route::get('variants/create/{productId}', [ProductVariantsController::class, 'create'])->name('variants.create');
    Route::post('variants/store/{productId}', [ProductVariantsController::class, 'store'])->name('variants.store');
        // phần order
    Route::get('order',[OrderController::class,'db_order'])->name('dashboard.order');
    Route::post('order/change/{id}',[OrderController::class,'db_order_change']);
    Route::get('order/{id}',[OrderController::class,'db_order_show']);

    // Các route resource chuẩn cho variants (index, show, edit, update, destroy) không cần productId
    Route::resource('variants', ProductVariantsController::class)->except(['create', 'store']);
    Route::get('images', [ImageProductVariantsController::class, 'index'])->name('image_product_variants.index');
    Route::prefix('variants/{variant}')->group(function () {

    Route::get('images/create', [ImageProductVariantsController::class, 'create'])->name('image_product_variants.create');
    Route::post('images', [ImageProductVariantsController::class, 'store'])->name('image_product_variants.store');
    Route::delete('images/{image}', [ImageProductVariantsController::class, 'destroy'])->name('image_product_variants.destroy');

    });

       // Route resource cho color và size
    Route::resource('colors', ColorController::class);
    Route::resource('sizes', SizeController::class);
});
