<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\Usercontroller;
use App\Http\Controllers\admin\SellerController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\StateController;
use App\Http\Controllers\admin\RatingController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\SellerPaymentController;
use App\Http\Controllers\admin\CouponController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::resource('login',AdminController::class);
    Route::get('logout',[AdminController::class,'logout'])->name('logout');
    Route::group(['middleware' => 'auth'], function () {

        Route::resource('dashboard',DashboardController::class);
        Route::resource('user',Usercontroller::class);
        Route::post('user/ajax',[Usercontroller::class,'ajax'])->name('user.ajax');
        Route::resource('seller',SellerController::class);
        Route::post('seller/ajax',[SellerController::class,'ajax'])->name('seller.ajax');
        Route::resource('category',CategoryController::class);
        Route::post('category/ajax',[CategoryController::class,'ajax'])->name('category.ajax');
        Route::resource('product',ProductController::class);
        Route::post('product/ajax',[ProductController::class,'ajax'])->name('product.ajax');
        Route::resource('order',OrderController::class);
        Route::post('order/ajax',[OrderController::class,'ajax'])->name('order.ajax');
        Route::resource('city',CityController::class);
        Route::post('city/ajax',[CityController::class,'ajax'])->name('city.ajax');
        Route::resource('state',StateController::class);
        Route::post('state/ajax',[StateController::class,'ajax'])->name('state.ajax');
        Route::resource('rating',RatingController::class);
        Route::post('rating/ajax',[RatingController::class,'ajax'])->name('rating.ajax');
        Route::resource('permission',PermissionController::class);
        Route::post('permission/ajax',[PermissionController::class,'ajax'])->name('permission.ajax');
        Route::resource('role',RoleController::class);
        Route::post('role/ajax',[RoleController::class,'ajax'])->name('role.ajax');
        Route::resource('sellerpayment',sellerPaymentController::class);
        Route::resource('coupon', CouponController::class);
        Route::post('coupon/ajax',[CouponController::class,'ajax'])->name('coupon.ajax');
    });

});

Route::group([
    'name' => 'user.',
    'prefix' => 'user',
    'middleware' => 'auth'
], function () {

    // URL: /user/profile
    // Route name: user.profile
    Route::get('profile', function () {
        return 'User profile';
    })->name('profile');

});

Route::group([
    'name' => 'front.',
    'prefix' => 'front'
], function () {

    // No middleware here
    // URL: /front/about-us
    // Route name: front.about
    Route::get('about-us', function () {
        return 'About us page';
    })->name('about');

});

