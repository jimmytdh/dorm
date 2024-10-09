<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageCtrl;
use App\Http\Controllers\UserCtrl;
use App\Http\Controllers\LoginCtrl;
use App\Http\Controllers\BedCtrl;
use App\Http\Controllers\ProfileCtrl;
use App\Http\Controllers\PaymentCtrl;
use App\Http\Controllers\NotificationCtrl;
use App\Http\Controllers\SMSCtrl;
use App\Http\Controllers\SettingsCtrl;


//Route::get('/login',[LoginCtrl::class,'login'])->name('login');
//Route::post('/login/validate',[LoginCtrl::class,'validateLogin']);
Route::match(['GET', 'POST'], '/login', [LoginCtrl::class,'login'])->name('login');
Route::get('/logout',[LoginCtrl::class,'logout']);

Route::group(['middleware' => 'auth'], function(){
    Route::get('/',[PageCtrl::class,'index']);
    Route::get('/dashboard',[PageCtrl::class,'dashboard']);

    //manage Beds
    Route::post('beds/search',[BedCtrl::class,'searchBeds'])->name('bed.search');
    Route::get('beds/assignment',[BedCtrl::class,'assignment']);
    Route::post('beds/assignment',[BedCtrl::class,'assignmentStore']);
    Route::post('beds/assignment/search',[BedCtrl::class,'searchAssignment']);
    Route::get('beds/assignment/{id}/edit',[BedCtrl::class,'assignmentEdit']);
    Route::post('beds/assignment/{id}/edit',[BedCtrl::class,'assignmentUpdate']);

    Route::resource('/beds',BedCtrl::class);


    //Manage Payments
    Route::get('report/payment',[PaymentCtrl::class,'paymentIndex']);
    Route::post('report/payment',[PaymentCtrl::class,'paymentProcess']);
    Route::post('report/payment/checkout',[PaymentCtrl::class,'paymentCheckout']);
    Route::post('report/payment/search',[PaymentCtrl::class,'paymentSearch']);

    Route::get('report/payment/history',[PaymentCtrl::class,'paymentHistory']);
    Route::post('report/payment/history',[PaymentCtrl::class,'paymentHistoryProcess']);
    Route::post('report/payment/history/search',[PaymentCtrl::class,'paymentHistorySearch']);
    Route::get('report/payment/history/{id}',[PaymentCtrl::class,'paymentInvoice']);

    Route::get('report/rental',[BedCtrl::class,'rentalLogs']);
    Route::post('report/rental/search',[BedCtrl::class,'rentalLogsSearch']);

    //manage notifications
    Route::get('notification/send',[NotificationCtrl::class,'sendNotification']);
    Route::get('notification/sms',[SMSCtrl::class,'sendSMS']);
    Route::post('notification/sendSMS',[SMSCtrl::class,'sendSMS']);


    //manage Profiles
    Route::post('profiles/search',[ProfileCtrl::class,'searchProfiles'])->name('profile.search');
    Route::resource('/profiles',ProfileCtrl::class);

    //manage fees
    Route::post('settings/fees',[SettingsCtrl::class,'updateFees']);

    //manage account
    Route::get('settings/account',[SettingsCtrl::class,'editAccount']);
    Route::post('settings/account',[SettingsCtrl::class,'updateAccount']);

    //manage Documents
    Route::post('users/search',[UserCtrl::class,'searchUsers'])->name('user.search');
    Route::resource('/users',UserCtrl::class);



    Route::get('/{any}',[PageCtrl::class,'defaultPage'])->where('any','.*');
});

