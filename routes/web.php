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
use App\Http\Controllers\NoOfCallController;


Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/exchange', [ExchangeController::class, 'index'])->name('admin.exchange.list');
Route::post('/exchange/post', [ExchangeController::class, 'store'])->name('admin.exchange.formPost');
Route::get('/phoneNumber', [PhoneNumberController::class, 'index'])->name('admin.phone_number.list');
Route::get('/numberOfCall', [NoOfCallController::class, 'index'])->name('admin.no_of_call.list');
Route::get('/user', [UserController::class, 'index'])->name('admin.user.list');
Route::post('/user/post', [UserController::class, 'store'])->name('admin.user.formPost');
Route::get('/assignNumebr', [DemoSendController::class, 'index'])->name('admin.demo_Send.list');
Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.list');
Route::get('/complaint', [ComplaintController::class, 'index'])->name('admin.complaint.list');
Route::get('/followup', [FollowUpController::class, 'index'])->name('admin.follow_up.list');
Route::get('/reject', [RejectController::class, 'index'])->name('admin.reject.list');
Route::get('/referId', [ReferIdController::class, 'index'])->name('admin.refer_id.list');
Route::get('/walk', [WalkController::class, 'index'])->name('admin.walk.list');
Route::get('/total-call', [TotalCallController::class, 'index'])->name('admin.total_call.list');

Route::post('/admin/phone-number/filepost', [PhoneNumberController::class, 'fileStore'])->name('admin.phone_number.filePost');
Route::post('/admin/phone-number/formPost', [PhoneNumberController::class, 'formStore'])->name('admin.phone_number.formPost');








Route::group(['middleware' => ['auth', 'admin']], function () {

});

Route::group(['middleware' => ['auth', 'assistant']], function () {

});

Route::group(['middleware' => ['auth', 'exchange']], function () {

});

Route::group(['middleware' => ['auth', 'customercare']], function () {

});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');






//Assistan Routes
Route::get('/assistan', [DashboardController::class, 'assistantIndex'])->name('assistan.dashboard');
// Route::get('/exchange', [ExchangeController::class, 'assistantIndex'])->name('assistan.exchange.list');
// Route::get('/phoneNumber', [PhoneNumberController::class, 'assistantIndex'])->name('assistan.phone_number.list');
// Route::get('/numberOfCall', [PhoneNumberController::class, 'assistantNoOfCallIndex'])->name('assistan.no_of_call.list');
// Route::get('/user', [UserController::class, 'assistantIndex'])->name('assistan.user.list');
// Route::get('/assignNumebr', [DemoSendController::class, 'assistantIndex'])->name('assistandemo_Send.list');
// Route::get('/assignNumebr', [AssignNumberController::class, 'assistantIndex'])->name('assistan.assign_number.list');
// Route::get('/customer', [CustomerController::class, 'assistantIndex'])->name('assistan.customer.list');
// Route::get('/complaint', [ComplaintController::class, 'assistantIndex'])->name('assistan.complaint.list');
// Route::get('/followup', [FollowUpController::class, 'assistantIndex'])->name('assistan.follow_up.list');
// Route::get('/reject', [RejectController::class, 'assistantIndex'])->name('assistan.reject.list');
// Route::get('/referId', [ReferIdController::class, 'assistantIndex'])->name('assistan.refer_id.list');
// Route::get('/walk', [WalkController::class, 'assistantIndex'])->name('assistan.walk.list');
// Route::get('/total-call', [TotalCallController::class, 'index'])->name('assistan.total_call.list');



// CustomerCare routes 
Route::get('/customer-care', [DashboardController::class, 'customerCareIndex'])->name('customercare.dashboard');
// Route::get('/exchange', [ExchangeController::class, 'customerCareIndex'])->name('customercare.exchange.list');
// Route::get('/phoneNumber', [PhoneNumberController::class, 'customerCareIndex'])->name('customercare.phone_number.list');
// Route::get('/numberOfCall', [PhoneNumberController::class, 'customerCareINoOfCallIndex'])->name('customercare.no_of_call.list');
// Route::get('/user', [UserController::class, 'customerCareIndex'])->name('customercare.user.list');
// Route::get('/assignNumebr', [DemoSendController::class, 'customerCareIndex'])->name('customercare.demo_Send.list');
// Route::get('/assignNumebr', [AssignNumberController::class, 'customerCareIndex'])->name('customercare.assign_number.list');
// Route::get('/customer', [CustomerController::class, 'customerCareIndex'])->name('customercare.customer.list');
// Route::get('/complaint', [ComplaintController::class, 'customerCareIndex'])->name('customercare.complaint.list');
// Route::get('/followup', [FollowUpController::class, 'customerCareIndex'])->name('customercare.follow_up.list');
// Route::get('/reject', [RejectController::class, 'customerCareIndex'])->name('customercare.reject.list');
// Route::get('/referId', [ReferIdController::class, 'customerCareIndex'])->name('customercare.refer_id.list');
// Route::get('/walk', [WalkController::class, 'customerCareIndex'])->name('customercare.walk.list');
// Route::get('/total-call', [TotalCallController::class, 'index'])->name('customercare.total_call.list');



//  user routes 
Route::get('/user-dashboard', [DashboardController::class, 'userIndex'])->name('user.dashboard');
// Route::get('/exchange', [ExchangeController::class, 'userIndex'])->name('user.exchange.list');
// Route::get('/phoneNumber', [PhoneNumberController::class, 'userIndex'])->name('user.phone_number.list');
// Route::get('/numberOfCall', [PhoneNumberController::class, 'userINoOfCallIndex'])->name('user.no_of_call.list');
// Route::get('/user', [UserController::class, 'userIndex'])->name('user.user.list');
// Route::get('/assignNumebr', [DemoSendController::class, 'index'])->name('user.demo_Send.list');
// Route::get('/assignNumebr', [AssignNumberController::class, 'userIndex'])->name('user.assign_number.list');
// Route::get('/customer', [CustomerController::class, 'userIndex'])->name('user.customer.list');
// Route::get('/complaint', [ComplaintController::class, 'userIndex'])->name('user.complaint.list');
// Route::get('/followup', [FollowUpController::class, 'userIndex'])->name('user.follow_up.list');
// Route::get('/reject', [RejectController::class, 'userIndex'])->name('user.reject.list');
// Route::get('/referId', [ReferIdController::class, 'userIndex'])->name('user.refer_id.list');
// Route::get('/walk', [WalkController::class, 'userIndex'])->name('user.walk.list');
// Route::get('/total-call', [TotalCallController::class, 'userIndex'])->name('user.total_call.list');