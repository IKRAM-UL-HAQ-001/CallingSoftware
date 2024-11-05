<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerCareController;
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
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TotalAmountController;



Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/post', [LoginController::class, 'login'])->name('login.post');
Route::get('/auth/logout', [LoginController::class, 'logout'])->name('login.logout');






Route::group(['middleware' => ['admin']], function () {
    Route::post('/passwordUpdate', [LoginController::class, 'update'])->name('password.update');
    Route::get('/post', [LoginController::class, 'logoutAll'])->name('logout.all');
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/exchange', [ExchangeController::class, 'index'])->name('admin.exchange.list');
    Route::post('/exchange/post', [ExchangeController::class, 'store'])->name('admin.exchange.formPost');
    Route::get('/phoneNumber', [PhoneNumberController::class, 'index'])->name('admin.phone_number.list');
    Route::get('/numberOfCall', [NoOfCallController::class, 'index'])->name('admin.no_of_call.list');
    Route::get('/user', [UserController::class, 'index'])->name('admin.user.list');
    Route::get('/customerCare', [CustomerCareController::class, 'index'])->name('admin.customer_care.list');
    Route::post('/customerCare/post', [CustomerCareController::class, 'store'])->name('admin.customer_care.formPost');
    Route::post('/user/post', [UserController::class, 'store'])->name('admin.user.formPost');
    Route::get('/demoSend', [DemoSendController::class, 'index'])->name('admin.demo_send.list');
    Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.list');
    Route::get('/complaint', [ComplaintController::class, 'index'])->name('admin.complaint.list');
    Route::get('/followup', [FollowUpController::class, 'index'])->name('admin.follow_up.list');
    Route::get('/reject', [RejectController::class, 'index'])->name('admin.reject.list');
    Route::get('/referId', [ReferIdController::class, 'index'])->name('admin.refer_id.list');
    Route::get('/walk', [WalkController::class, 'index'])->name('admin.walk.list');
    Route::get('/totalCall', [TotalCallController::class, 'index'])->name('admin.total_call.list');
    Route::get('/totalAmount', [TotalAmountController::class, 'index'])->name('admin.amount.list');

    Route::post('/admin/phoneNumber/filePost', [PhoneNumberController::class, 'fileStore'])->name('admin.phone_number.filePost');
    Route::post('/admin/phoneNumber/formPost', [PhoneNumberController::class, 'formStore'])->name('admin.phone_number.formPost');

});

Route::group(['middleware' => ['assistant']], function () {
    Route::get('/assistant', [DashboardController::class, 'assistantIndex'])->name('assistant.dashboard');
    Route::get('/assistantExchange', [ExchangeController::class, 'assistantIndex'])->name('assistant.exchange.list');
    Route::get('/assistantPhoneNumber', [PhoneNumberController::class, 'assistantIndex'])->name('assistant.phone_number.list');
    Route::get('/assistantNumberOfCall', [NoOfCallController::class, 'assistantIndex'])->name('assistant.no_of_call.list');
    Route::get('/assistantUser', [UserController::class, 'assistantIndex'])->name('assistant.user.list');
    Route::get('/assistantDemoSend', [DemoSendController::class, 'assistantIndex'])->name('assistant.demo_send.list');
    Route::get('/assistantAssignNumebr', [AssignNumberController::class, 'assistantIndex'])->name('assistant.assign_number.list');
    Route::get('/assistantCustomer', [CustomerController::class, 'assistantIndex'])->name('assistant.customer.list');
    Route::get('/assistantComplaint', [ComplaintController::class, 'assistantIndex'])->name('assistant.complaint.list');
    Route::get('/assistantFollowup', [FollowUpController::class, 'assistantIndex'])->name('assistant.follow_up.list');
    Route::get('/assistantReject', [RejectController::class, 'assistantIndex'])->name('assistant.reject.list');
    Route::get('/assistantReferId', [ReferIdController::class, 'assistantIndex'])->name('assistant.refer_id.list');
    Route::get('/assistantWalk', [WalkController::class, 'assistantIndex'])->name('assistant.walk.list');
    Route::get('/assistantTotalCall', [TotalCallController::class, 'index'])->name('assistant.total_call.list');
});

Route::group(['middleware' => ['exchange']], function () {
    Route::get('/userDashboard', [DashboardController::class, 'exchangeIndex'])->name('exchange.dashboard');
    Route::get('/userNumberOfCall', [NoOfCallController::class, 'exchangeIndex'])->name('exchange.no_of_call.list');
    Route::get('/userDemoSend', [DemoSendController::class, 'exchangeIndex'])->name('exchange.demo_send.list');
    Route::get('/userAssignNumebr', [AssignNumberController::class, 'exchangeIndex'])->name('exchange.assign_number.list');
    Route::get('/userCustomer', [CustomerController::class, 'exchangeIndex'])->name('exchange.customer.list');
    Route::get('/userComplaint', [ComplaintController::class, 'exchangeIndex'])->name('exchange.complaint.list');
    Route::get('/userFollowup', [FollowUpController::class, 'exchangeIndex'])->name('exchange.follow_up.list');
    Route::get('/userReject', [RejectController::class, 'exchangeIndex'])->name('exchange.reject.list');
    Route::get('/userReferId', [ReferIdController::class, 'exchangeIndex'])->name('exchange.refer_id.list');
    Route::get('/userWalk', [WalkController::class, 'exchangeIndex'])->name('exchange.walk.list');
    Route::get('/userTotalCall', [TotalCallController::class, 'exchangeIndex'])->name('exchange.total_call.list');
});

Route::group(['middleware' => [ 'customercare']], function () {
    Route::get('/customer-cares', [DashboardController::class, 'customerCareIndex'])->name('customer_care.dashboard');
    Route::get('/complaints', [ComplaintController::class, 'customerCareIndex'])->name('customer_care.complaint.list');
    Route::get('/followups', [FollowUpController::class, 'customerCareIndex'])->name('customer_care.follow_up.list');
    Route::get('/rejects', [RejectController::class, 'customerCareIndex'])->name('customer_care.reject.list');
    Route::get('/walks', [WalkController::class, 'customerCareIndex'])->name('customer_care.walk.list');
});




