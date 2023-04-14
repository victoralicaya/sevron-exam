<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/products', [ProductController::class, 'index']);

    Route::post('/cart', [UserController::class, 'addToCart']);
    Route::get('/checkout', [UserController::class, 'checkout']);

    Route::middleware('admin')->group(function (){
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        Route::get('/orders', [UserController::class, 'orders']);
        Route::put('/orders/{order}', [UserController::class, 'changeOrderStatus']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
