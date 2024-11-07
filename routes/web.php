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
use App\Http\Controllers\NewIdController;



Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/post', [LoginController::class, 'login'])->name('login.post');
Route::get('/auth/logout', [LoginController::class, 'logout'])->name('login.logout');






Route::group(['middleware' => ['admin']], function () {
    
    Route::post('/admin/passwordUpdate', [LoginController::class, 'update'])->name('password.update');
    Route::get('/admin/post', [LoginController::class, 'logoutAll'])->name('logout.all');
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/exchange', [ExchangeController::class, 'index'])->name('admin.exchange.list');
    Route::post('/admin/exchangeUsers', [ExchangeController::class, 'exchnageUsers'])->name('admin.exchange.userlist');
    Route::post('/admin/exchange/post', [ExchangeController::class, 'store'])->name('admin.exchange.formPost');
    Route::post('/admin/exchange/popStore', [ExchangeController::class, 'popDashboard'])->name('admin.exchange.popUpDashboard');

    
    Route::get('/admin/phoneNumber', [PhoneNumberController::class, 'index'])->name('admin.phone_number.list');
    Route::get('/admin/numberOfCall', [NoOfCallController::class, 'index'])->name('admin.no_of_call.list');
    
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.list');    
    Route::post('/admin/user/status', [UserController::class, 'userStatus'])->name('admin.user.status');

    Route::get('/admin/customerCare', [CustomerCareController::class, 'index'])->name('admin.customer_care.exchangelist');
    Route::post('/admin/customerCare/store', [CustomerCareController::class, 'userlist'])->name('admin.customer_care.list');
    Route::post('/admin/customerCare/popStore', [CustomerCareController::class, 'popDashboard'])->name('admin.customer_care.popUpDashboard');
   
    Route::post('/admin/customerCare/post', [CustomerCareController::class, 'store'])->name('admin.customer_care.formPost');    
    Route::post('/user/post', [UserController::class, 'store'])->name('admin.user.formPost');
    Route::get('/demoSend', [DemoSendController::class, 'index'])->name('admin.demo_send.list');
    Route::get('/complaint', [ComplaintController::class, 'index'])->name('admin.complaint.list');
    Route::get('/followup', [FollowUpController::class, 'index'])->name('admin.follow_up.list');
    Route::get('/reject', [RejectController::class, 'index'])->name('admin.reject.list');
    Route::get('/NewId', [NewIdController::class, 'index'])->name('admin.new_id.list');
    Route::get('/referId', [ReferIdController::class, 'index'])->name('admin.refer_id.list');
    Route::get('/walk', [WalkController::class, 'index'])->name('admin.walk.list');
    Route::get('/totalCall', [TotalCallController::class, 'index'])->name('admin.total_call.list');
    // Route::get('/totalAmount', [TotalAmountController::class, 'index'])->name('admin.amount.list');
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
    Route::get('/assistantComplaint', [ComplaintController::class, 'assistantIndex'])->name('assistant.complaint.list');
    Route::get('/assistantFollowup', [FollowUpController::class, 'assistantIndex'])->name('assistant.follow_up.list');
    Route::get('/assistantReject', [RejectController::class, 'assistantIndex'])->name('assistant.reject.list');
    Route::get('/assistantReferId', [ReferIdController::class, 'assistantIndex'])->name('assistant.refer_id.list');
    Route::get('/assistantWalk', [WalkController::class, 'assistantIndex'])->name('assistant.walk.list');
    Route::get('/assistantTotalCall', [TotalCallController::class, 'index'])->name('assistant.total_call.list');
});

Route::group(['middleware' => ['exchange']], function () {
    Route::get('/user/Dashboard', [DashboardController::class, 'exchangeIndex'])->name('exchange.dashboard');
    Route::get('/user/NumberOfCall', [NoOfCallController::class, 'exchangeIndex'])->name('exchange.no_of_call.list');
    Route::get('/user/AssignNumebr', [AssignNumberController::class, 'exchangeIndex'])->name('exchange.assign_number.list');
 
    Route::get('/user/DemoSend', [DemoSendController::class, 'exchangeIndex'])->name('exchange.demo_send.list');
    Route::post('/user/DemoSend/post', [DemoSendController::class, 'store'])->name('exchange.demo_send.formPost');
    
    Route::get('/user/Complaint', [ComplaintController::class, 'exchangeIndex'])->name('exchange.complaint.list');
    Route::post('/user/Complaint/post', [ComplaintController::class, 'store'])->name('exchange.complaint.formPost');
    
    Route::get('/user/Followup', [FollowUpController::class, 'exchangeIndex'])->name('exchange.follow_up.list');
    Route::post('/user/Followup/post', [FollowUpController::class, 'store'])->name('exchange.follow_up.formPost');
    
    Route::get('/user/Reject', [RejectController::class, 'exchangeIndex'])->name('exchange.reject.list');
    Route::post('/user/Reject/post', [RejectController::class, 'store'])->name('exchange.reject.formPost');

    Route::get('/user/ReferId', [ReferIdController::class, 'exchangeIndex'])->name('exchange.refer_id.list');
    Route::post('/user/ReferId/post', [ReferIdController::class, 'store'])->name('exchange.refer_id.formPost');

    Route::get('/user/Walk', [WalkController::class, 'exchangeIndex'])->name('exchange.walk.list');
    Route::post('/user/Walk/post', [WalkController::class, 'store'])->name('exchange.walk.formPost');

    Route::get('/user/Customer', [NewIdController::class, 'exchangeIndex'])->name('exchange.new_id.list');
    Route::post('/user/Customer/post', [NewIdController::class, 'store'])->name('exchange.new_id.formPost');

    Route::get('/user/Complaint', [ComplaintController::class, 'exchangeIndex'])->name('exchange.complaint.list');
    Route::post('/user/Complaint/post', [ComplaintController::class, 'store'])->name('exchange.complaint.formPost');
});

Route::group(['middleware' => [ 'customercare']], function () {
    Route::get('/customercare/Dashboard', [DashboardController::class, 'customercareIndex'])->name('customer_care.dashboard');
    Route::get('/customercare/NumberOfCall', [NoOfCallController::class, 'customercareIndex'])->name('customer_care.no_of_call.list');
    Route::get('/customercare/AssignNumebr', [AssignNumberController::class, 'customercareIndex'])->name('customer_care.assign_number.list');
 
    Route::get('/customercare/DemoSend', [DemoSendController::class, 'customercareIndex'])->name('customer_care.demo_send.list');
    Route::post('/customercare/DemoSend/post', [DemoSendController::class, 'store'])->name('customer_care.demo_send.formPost');
    
    Route::get('/customercare/Complaint', [ComplaintController::class, 'customercareIndex'])->name('customer_care.complaint.list');
    Route::post('/customercare/Complaint/post', [ComplaintController::class, 'store'])->name('customer_care.complaint.formPost');
    
    Route::get('/customercare/Followup', [FollowUpController::class, 'customercareIndex'])->name('customer_care.follow_up.list');
    Route::post('/customercare/Followup/post', [FollowUpController::class, 'store'])->name('customer_care.follow_up.formPost');
    
    Route::get('/customercare/Reject', [RejectController::class, 'customercareIndex'])->name('customer_care.reject.list');
    Route::post('/customercare/Reject/post', [RejectController::class, 'store'])->name('customer_care.reject.formPost');

    Route::get('/customercare/ReferId', [ReferIdController::class, 'customercareIndex'])->name('customer_care.refer_id.list');
    Route::post('/customercare/ReferId/post', [ReferIdController::class, 'store'])->name('customercare.refer_id.formPost');

    Route::get('/customercare/Walk', [WalkController::class, 'customercareIndex'])->name('customer_care.walk.list');
    Route::post('/customercare/Walk/post', [WalkController::class, 'store'])->name('customercare.walk.formPost');

    Route::get('/customercare/NewId', [NewIdController::class, 'customercareIndex'])->name('customer_care.new_id.list');
    Route::post('/customercare/NewId/post', [NewIdController::class, 'store'])->name('customercare.new_id.formPost');

});




