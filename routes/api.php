<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[AuthController::class,'login']);
Route::post('/createAccount',[AuthController::class,'createAccount']);

Route::middleware('auth:api')->group(function (){
//ProductControllerAPI'S
    Route::prefix("products")->group(function () {
        Route::get('/',[ProductController::class,'index']);
        Route::post('/',[ProductController::class,'store']);
        Route::get('/{id}',[ProductController::class,'show']);
        Route::post('/{id}',[ProductController::class,'update']);
        Route::delete('/{id}',[ProductController::class,'destroy']);

        /////////////
        Route::prefix("/{product}/comments")->group(function(){
            Route::get('/',[CommentController::class,'index']);
            Route::post('/',[CommentController::class,'store']);
            Route::put('/{comment}',[CommentController::class,'update']);
            Route::delete('/',[CommentController::class,'destroy']);
        });
        Route::prefix("/{product}/likes")->group(function() {
            Route::get('/', [LikeController::class, 'index']);
            Route::post('/', [LikeController::class, 'store']);
            Route::put('/{like}', [LikeController::class, 'update']);
            Route::delete('/', [LikeController::class, 'destroy']);
        });
        });
});
//CategoriesController API'S
Route::prefix("categories")->group(function () {
    Route::get('/',[CategoryController::class,'index']);
    Route::post('/',[CategoryController::class,'store']);
    Route::get('/{id}',[CategoryController::class,'show']);
    Route::post('/{id}',[CategoryController::class,'update']);
    Route::delete('/{id}',[CategoryController::class,'destroy']);
});
Route::get('category/search',[CategoryController::class,'show_name']);


Route::get('product/search',[ProductController::class,'search_products']);
