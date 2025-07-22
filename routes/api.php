<?php

use App\Http\Controllers\API\BannerApiController;
use App\Http\Controllers\API\BrandApiController;
use App\Http\Controllers\API\CategoryApiController;
use App\Http\Controllers\API\ProductApiController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::apiResource('products', ProductApiController::class);
    Route::apiResource('brands', BrandApiController::class);
    Route::apiResource('categories', CategoryApiController::class);
    Route::apiResource('banners', BannerApiController::class);
});
