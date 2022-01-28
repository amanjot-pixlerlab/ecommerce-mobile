<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ForgetPassword;
use App\Http\Controllers\API\PopularProductController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\UserController;
use Laravel\Sanctum\Sanctum;

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

Route::middleware(['auth:sanctum'])->group(function () {
    //popular products apis
    Route::get('popular-product', [PopularProductController::class, 'get']);
    Route::post('popular-product/add', [PopularProductController::class, 'add']);
    Route::post('popular-product/delete', [PopularProductController::class, 'delete']);

    //products apis
    Route::get('all', [ProductController::class, 'get']);
    Route::get('search/{name}', [ProductController::class, 'search']);
    Route::get('filter/{condition}', [ProductController::class, 'filter']);

    //reviews apis
    Route::get('reviews/product/{product_id}', [ReviewController::class, 'get']);
    Route::post('reviews/add', [ReviewController::class, 'add']);
    Route::post('reviews/delete', [ReviewController::class, 'delete']);

    //user apis
    Route::get('user', [UserController::class, 'get']);
    Route::post('user/update', [UserController::class, 'update']);
    Route::post('user/change-password', [UserController::class, 'change_password']);
});

//auth apis
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

//forget password api
Route::post('forget-passowrd', [ForgetPassword::class, 'forget_password']);
Route::post('reset-passowrd/', [ForgetPassword::class, 'reset_password']);