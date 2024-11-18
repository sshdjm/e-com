<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


Route::group([
    'middleware' => 'jwt.auth',
], function () {
    // Маршруты для корзины
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'getCart'])->name('cart.get');
        Route::post('/', [CartController::class, 'addItem'])->name('cart.add');
        Route::delete('/{cartItemId}', [CartController::class, 'removeItem'])->name('cart.remove');
    });

    // Маршруты для заказов
    Route::apiResource('orders', OrderController::class);
    Route::post('/create-order', [PaymentController::class, 'createOrder'])->name('order.create');
});


Route::apiResource('products', ProductController::class);

Route::post('/webhook', [PaymentController::class, 'handleWebhook'])->name('payment.webhook');

Route::get('/test', [TestController::class, 'test'])->name('test');

























//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
//
//
//Route::group([
//
//    'middleware' => 'api',
//    'prefix' => 'auth'
//
//], function ($router) {
//
//
//    Route::post('login', [AuthController::class, 'login']);
//    Route::post('logout', [AuthController::class, 'logout']);
//    Route::post('refresh', [AuthController::class, 'refresh']);
//    Route::post('me', [AuthController::class, 'me']);
//
//
//});
//
//Route::group(['namespace' => 'cart','middleware' => 'jwt.auth'], function () {
//    Route::get('/cart', [CartController::class, 'getCart']);
//    Route::post('/cart', [CartController::class, 'addItem']);
//    Route::delete('/cart/items/{cartItemId}', [CartController::class, 'removeItem']);
//
//    Route::post('/cart/pay', [CartController::class, 'pay'])->name('basket.pay');
//
//});
//
//
//Route::apiResource('orders', OrderController::class);
//Route::post('/create-order', [PaymentController::class, 'createOrder'])->middleware('jwt.auth');
//Route::post('/webhook', [PaymentController::class, 'handleWebhook']);
//
//
//Route::apiResource('products', ProductController::class);
//
//
//
//
//Route::get('/test', [TestController::class, 'test']);