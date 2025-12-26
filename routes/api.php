<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersGreenHouseController;
use App\Http\Controllers\SellersController;
use App\Http\Controllers\SellerReviewController;
use App\Http\Controllers\SellerFeedbackController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrdersItemsController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource( '/user_green_house' ,UsersGreenHouseController::class);
Route::apiResource( '/sellers' ,SellersController::class);
Route::apiResource( '/seller_review' ,SellerReviewController::class);
Route::apiResource( '/seller_feedback' ,SellerFeedbackController::class);
Route::apiResource( '/products' ,ProductsController::class);
Route::apiResource( '/orders' ,OrdersController::class);
Route::apiResource( '/orders_items' ,OrdersItemsController::class);
