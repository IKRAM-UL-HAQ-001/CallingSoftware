<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignNumberController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DemoSendController;
use App\Http\Controllers\RejectController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\WalkController;
use App\Http\Controllers\ReferIdController;
use App\Http\Controllers\TotalCallController;


Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/exchange', [ExchangeController::class, 'index'])->name('admin.exchange.list');
Route::get('/phoneNumber', [PhoneNumberController::class, 'index'])->name('admin.phone_number.list');
Route::get('/numberOfCall', [PhoneNumberController::class, 'noOfCallIndex'])->name('admin.no_of_call.list');
Route::get('/user', [UserController::class, 'index'])->name('admin.user.list');
Route::get('/assignNumebr', [DemoSendController::class, 'index'])->name('admin.demo_Send.list');
Route::get('/assignNumebr', [AssignNumberController::class, 'index'])->name('admin.assign_number.list');
Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.list');
Route::get('/complaint', [ComplaintController::class, 'index'])->name('admin.complaint.list');
Route::get('/followup', [FollowUpController::class, 'index'])->name('admin.follow_up.list');
Route::get('/reject', [RejectController::class, 'index'])->name('admin.reject.list');
Route::get('/referId', [ReferIdController::class, 'index'])->name('admin.refer_id.list');
Route::get('/walk', [WalkController::class, 'index'])->name('admin.walk.list');
Route::get('/total-call', [TotalCallController::class, 'index'])->name('admin.total_call.list');


Route::post('/admin/phone-number/post', [PhoneNumberController::class, 'store'])->name('admin.phone_number.post');








Route::group(['middleware' => ['auth', 'admin']], function () {

});

Route::group(['middleware' => ['auth', 'assistant']], function () {

});

Route::group(['middleware' => ['auth', 'exchange']], function () {

});

Route::group(['middleware' => ['auth', 'customercare']], function () {

});