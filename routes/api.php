<?php

use App\Http\Controllers\Api\Buyer\ProductController as BuyerProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Auth\SellerAuthController;
use Illuminate\Support\Facades\Route;

Route::post('login', [SellerAuthController::class, 'login']);

Route::group(['prefix'=>'seller','middleware' => 'auth:sanctum'], function () {
    Route::apiResource('products', SellerProductController::class);
    Route::post('logout', [SellerAuthController::class, 'logout']);

});

Route::get('categories', [CategoryController::class, 'index']);
Route::get('products', BuyerProductController::class);
