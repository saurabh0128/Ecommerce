<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\SellerController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\RoleController;
use App\Http\Controllers\api\v1\ProductController;
use App\Http\Controllers\api\v1\CouponController;
use App\Http\Controllers\api\v1\ProfileController;
use App\Http\Controllers\api\v1\PermissionController;
use App\Http\Controllers\api\v1\RatingController;
use App\Http\Controllers\api\v1\OrderController;
use App\Http\Controllers\api\v1\SliderController;
use App\Http\Controllers\api\v1\RolePermissionsController;


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
    Route::resource('/user',UserController::class);
    
    Route::group(['middleware' => 'auth:api','prefix' => 'v1'],function(){
        Route::resource('/seller',SellerController::class);
        Route::resource('/category',CategoryController::class);
       // Route::resource('/role',RoleController::class);
        Route::resource('/product',ProductController::class);
        Route::resource('/coupon',CouponController::class);
        Route::resource('/profile',ProfileController::class);
        Route::resource('/permission',PermissionController::class);
        Route::resource('/rating',RatingController::class);
        Route::resource('/order',OrderController::class);
        Route::resource('/slider',SliderController::class);
        Route::resource('/rolepermission',RolePermissionsController::class);

    });
    // Route::middleware('auth:api')->resource('/user','App\Http\Controllers\api\v1\UserController@index');

