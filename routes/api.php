<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\RegistrationController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\ProductController;
use App\Http\Controllers\api\v1\OrderController;
use App\Http\Controllers\api\v1\RatingController;
use App\Http\Controllers\api\v1\CartController;
use App\Http\Controllers\api\v1\CouponController;
use App\Http\Controllers\api\v1\WishlistController;
use App\Http\Controllers\api\v1\SellerController;
 

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

   Route::group(['prefix' => 'v1'],function(){

      Route::post('registration',[RegistrationController::class,'userRegistration'])->name('registration.userRegistration');
      Route::post('login',[LoginController::class,'userLogin'])->name('login.userLogin');

         Route::resource('/product',ProductController::class)->only(['index','show']);
         Route::get('category',[CategoryController::class,'categoryDetails'])->name('category.categoryDetails');
         Route::get('seller',[SellerController::class,'index'])->name('seller.sellerDeatils');
         Route::group(['middleware' => 'auth:api'],function(){
      
         Route::resource('/order',OrderController::class);
         Route::post('/rating',[RatingController::class,'userRating'])->name('rating.userRating');
         Route::resource('/cart',CartController::class);
         Route::resource('/coupon',CouponController::class);
         Route::resource('/wishlist',WishlistController::class);
         Route::get('/authenticated',function(){
            return false;
         });         
      });
   });
   
    
    
    // Route::middleware('auth:api')->resource('/user','App\Http\Controllers\api\v1\UserController@index');

