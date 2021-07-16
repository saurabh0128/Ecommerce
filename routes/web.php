<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\Usercontroller;
use App\Http\Controllers\admin\SellerController;
use App\Http\Controllers\admin\CategoryController;

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
    Route::group(['middleware' => 'auth'], function () {

        Route::resource('dashboard',DashboardController::class);
        Route::resource('user',Usercontroller::class);
        Route::resource('seller',SellerController::class);
        Route::resource('category',CategoryController::class);

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

