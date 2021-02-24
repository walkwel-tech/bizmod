<?php

use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/home')->name('welcome');

Auth::routes(['verify' => true]);

Route::get('/images/{folder}/{path}', 'ImageController@showImage')
        ->where('path', '.+')
        ->name('images.get');


Route::get('/profile/avatar/{path}', 'ImageController@show')
        ->where('path', '.+')
        ->name('user.avatar.get');
Route::middleware(['auth'])->group(function() {
});

Route::get('login/otp', 'Auth\OtpController@showLoginForm')->name('login.otp');
Route::post('login/otp', 'Auth\OtpController@login');

Route::get('login/otp/request', 'Auth\OtpController@showLoginWithOTPForm')->name('login.otp.request');
Route::post('login/otp/request', 'Auth\OtpController@requestOTP');

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('login.social');
Route::get('login/{provider}/callback','Auth\LoginController@handleProviderCallback');

Route::prefix('locations')->name('locations.')->group(function () {
    Route::get('countries', 'Backend\LocationsController@countries')->name('countries');
    Route::get('states', 'Backend\LocationsController@states')->name('states');
    Route::get('cities', 'Backend\LocationsController@cities')->name('cities');
});
