<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\CareCenterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\FollowUpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name("auth.login"); 
Route::post('/login/check', [LoginController::class, 'store'])->name('auth.login.store');
Route::get('/auth/logout', [LoginController::class, 'logout'])->name('login.logout');


Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin/dashboard',[AdminController::class, 'index'])->name("admin.dashboard"); 

    // exchange user
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.list');
    Route::post('/admin/user/post', [UserController::class, 'store'])->name('admin.user.post');
    Route::post('/admin/user/update', [UserController::class, 'update'])->name('admin.user.update');
    Route::post('/admin/user/destroy', [UserController::class, 'destroy'])->name('admin.user.destroy');
    
    // exchange
    Route::get('/admin/exchange', [ExchangeController::class, 'exchangeList'])->name('admin.exchange.list');
    Route::post('/admin/exchange/post', [ExchangeController::class, 'store'])->name('admin.exchange.store');
    Route::post('/admin/exchange/destroy', [ExchangeController::class, 'destroy'])->name('admin.exchange.destroy');
});

Route::group(['middleware' => ['auth', 'role:exchange']], function () {
    Route::get('/exchange/dashboard',[ExchangeController::class, 'index'])->name("exchange.dashboard");
});

Route::group(['middleware' => ['auth', 'role:carecenter']], function () {
    Route::get('/carecenter/dashboard',[CareCenterController::class, 'index'])->name("care_center.dashboard");
    
    // complaint
    Route::get('/carecenter/complain', [ComplainController::class, 'index'])->name('care_center.complain.list');
    Route::post('/carecenter/complain/post', [ComplainController::class, 'store'])->name('care_center.complain.store');
    Route::post('/carecenter/complain/destroy', [ComplainController::class, 'destroy'])->name('care_center.complain.destroy');

        // follow up
        Route::get('/carecenter/followup', [FollowUpController::class, 'index'])->name('care_center.follow_up.list');
        Route::post('/carecenter/followup/post', [FollowUpController::class, 'store'])->name('care_center.follow_up.store');
        Route::post('/carecenter/followup/destroy', [FollowUpController::class, 'destroy'])->name('care_center.follow_up.destroy');
});