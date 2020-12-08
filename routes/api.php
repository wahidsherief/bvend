<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('details', 'API\UserController@details');
});

Route::prefix('user')->group(function () {
    Route::get('send', 'Auth\AuthController@showSendOTPForm')->name('user.sentOTPForm');
    Route::post('send', 'Auth\LoginController@sendOTP')->name('user.sendOTP.submit');
    Route::get('submit', 'Auth\LoginController@showSubmitOTPForm')->name('user.submitOTPForm');
    Route::post('submit', 'Auth\LoginController@submitOTP')->name('user.otp.submit');
});

Route::get('/lockers/{code}', 'LockerController@getLockers');
// Route::get('/open/{model}/{machine_id}/{locker_id}', 'VendorController@openLocker')->name('vendor.open_locker');

Route::post('/turnoff', 'LockerController@turnOffLockers');

Route::get('/{type}/{model}/{mid}/{lid}', 'LockerController@getLocker');

Route::prefix('bkash')->group(function () {
    Route::post('/', 'BkashController@processInput');
    Route::get('/{token}', 'BkashController@index');
    Route::get('/agreement/{token}', 'BkashController@executeAgreement');
    Route::get('/payment/{token}', 'BkashController@executePayment');
    Route::get('/cancel/{id}', 'BkashController@cancelAgreement');
    Route::get('/error/{message}', fn () => null);
    Route::get('/success/{message}', fn () => null);
    Route::get('/check/{id}', 'BkashController@checkAgreement');
    Route::get('/exit/{token}', 'BkashController@exit');
});
