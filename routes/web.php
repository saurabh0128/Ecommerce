<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\AdminController;

use App\Http\Controllers\admin\DashboardController;

use App\Http\Controllers\admin\Usercontroller;

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



Route::resource('admin',AdminController::class);

Route::resource('dashboard',DashboardController::class);

Route::resource('user',Usercontroller::class);
