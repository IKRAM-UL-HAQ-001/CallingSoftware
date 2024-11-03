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
use App\Http\Controllers\LoginController;



Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/post', [LoginController::class, 'login'])->name('login.post');
Route::get('/auth/logout', [LoginController::class, 'logout'])->name('login.logout');






Route::group(['middleware' => ['admin']], function () {
    //update password
    Route::post('/passwordUpdate', [LoginController::class, 'update'])->name('password.update');
    
    //logout all
    Route::get('/post', [LoginController::class, 'logoutAll'])->name('logout.all');

    //dashboard
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    //exchange
    Route::get('/exchange', [ExchangeController::class, 'index'])->name('admin.exchange.list');
    Route::post('/exchange/post', [ExchangeController::class, 'store'])->name('admin.exchange.formPost');
    
    Route::get('/phoneNumber', [PhoneNumberController::class, 'index'])->name('admin.phone_number.list');
    Route::get('/numberOfCall', [NoOfCallController::class, 'index'])->name('admin.no_of_call.list');
    Route::get('/user', [UserController::class, 'index'])->name('admin.user.list');
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
    Route::get('/assistantNumberOfCall', [PhoneNumberController::class, 'assistantNoOfCallIndex'])->name('assistant.no_of_call.list');
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

Route::group(['middleware' => ['auth', 'exchange']], function () {
//  user routes 
Route::get('/userDashboard', [DashboardController::class, 'userIndex'])->name('user.dashboard');
Route::get('/userNumberOfCall', [PhoneNumberController::class, 'userINoOfCallIndex'])->name('user.no_of_call.list');
Route::get('/userDemoSend', [DemoSendController::class, 'index'])->name('user.demo_send.list');
Route::get('/userAssignNumebr', [AssignNumberController::class, 'userIndex'])->name('user.assign_number.list');
Route::get('/userCustomer', [CustomerController::class, 'userIndex'])->name('user.customer.list');
Route::get('/userComplaint', [ComplaintController::class, 'userIndex'])->name('user.complaint.list');
Route::get('/userFollowup', [FollowUpController::class, 'userIndex'])->name('user.follow_up.list');
Route::get('/userReject', [RejectController::class, 'userIndex'])->name('user.reject.list');
Route::get('/userReferId', [ReferIdController::class, 'userIndex'])->name('user.refer_id.list');
Route::get('/userWalk', [WalkController::class, 'userIndex'])->name('user.walk.list');
Route::get('/userTotalCall', [TotalCallController::class, 'userIndex'])->name('user.total_call.list');
});

Route::group(['middleware' => ['auth', 'customercare']], function () {

});


//Assistan Routes




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



