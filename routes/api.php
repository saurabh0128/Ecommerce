<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\SellerController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\RoleController;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


    Route::resource('login',LoginController::class);
    
    Route::group(['middleware' => 'auth:api'],function(){
        Route::resource('/user',UserController::class);
        Route::resource('/seller',SellerController::class);
        Route::resource('/category',CategoryController::class);
        Route::resource('/role',RoleController::class);

    });
    // Route::middleware('auth:api')->resource('/user','App\Http\Controllers\api\v1\UserController@index');

