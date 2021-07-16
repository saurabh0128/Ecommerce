<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminController;

use App\Http\Controllers\admin\DashboardController;

use App\Http\Controllers\admin\Usercontroller;

use App\Http\Controllers\admin\SellerController;
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



Route::resource('/backend/login',AdminController::class);

Route::resource('/backend/dashboard',DashboardController::class);

Route::resource('/backend/user',Usercontroller::class);

Route::resource('/backend/seller',SellerController::class);


