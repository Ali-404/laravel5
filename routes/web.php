<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware("2fa_verified");



Route::get('/verify-code', 'Auth\LoginCodeController@showForm')->name('verify.code.form');
Route::post('/verify-code', 'Auth\LoginCodeController@verifyCode')->name('verify.code');
Route::post('/resend-code', 'Auth\LoginCodeController@resendCode')->name('resend.code');


Route::get("/2fa/setup", "TwoFactorAuthController@setup2FA")->name("2fa.setup");
Route::post("/2fa/verify", "TwoFactorAuthController@verify2FA")->name("2fa.verify");
