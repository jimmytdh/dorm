<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageCtrl;
use App\Http\Controllers\UserCtrl;
use App\Http\Controllers\LoginCtrl;
use App\Http\Controllers\BedCtrl;
use App\Http\Controllers\ProfileCtrl;


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


    //manage Profiles
    Route::post('profiles/search',[ProfileCtrl::class,'searchProfiles'])->name('profile.search');
    Route::resource('/profiles',ProfileCtrl::class);

    //manage Documents
    Route::post('users/search',[UserCtrl::class,'searchUsers'])->name('user.search');
    Route::resource('/users',UserCtrl::class);



    Route::get('/{any}',[PageCtrl::class,'defaultPage'])->where('any','.*');
});

