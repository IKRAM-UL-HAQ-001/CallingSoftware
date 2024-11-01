<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\PhoneNumberController;

Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/exchange', [ExchangeController::class, 'index'])->name('admin.exchange.list');
Route::get('/phoneNumber', [PhoneNumebrController::class, 'index'])->name('admin.phone_number.list');
Route::group(['middleware' => ['auth', 'admin']], function () {

});

Route::group(['middleware' => ['auth', 'assistant']], function () {

});

Route::group(['middleware' => ['auth', 'exchange']], function () {

});

Route::group(['middleware' => ['auth', 'customercare']], function () {

});