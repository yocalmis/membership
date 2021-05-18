<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthControl;
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

Route::post('/', function () {return;});
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/get_token', [UserController::class, 'get_token']);

Route::middleware([AuthControl::class])->group(function () {

    Route::post('/category/all', [CategoryController::class, 'index']);
    Route::post('/category/add', [CategoryController::class, 'store']);
    Route::post('/category/show', [CategoryController::class, 'show']);
    Route::post('/category/update', [CategoryController::class, 'update']);
    Route::post('/category/delete', [CategoryController::class, 'destroy']);
    Route::post('/product/all', [ProductController::class, 'index']);
    Route::post('/product/add', [ProductController::class, 'store']);
    Route::post('/product/show', [ProductController::class, 'show']);
    Route::post('/product/update', [ProductController::class, 'update']);
    Route::post('/product/delete', [ProductController::class, 'destroy']);

});

//Route::post('/category/all', [CategoryController::class, 'index'])->middleware('authcontrol');
