<?php

Route::redirect('/', '/admin/home');

Route::group(['middleware' => 'verified'], function () {
    Route::get('/home', 'DashboardController@index')->name('home');
});

Route::get('/page/trashed', 'PageController@trashed')->name('page.trashed');
Route::post('/page/restore', 'PageController@restore')->name('page.restore');
Route::delete('/page/delete/permanent', 'PageController@delete')->name('page.delete');
Route::resource('page', 'PageController');

Route::get('/category/trashed', 'CategoryController@trashed')->name('category.trashed');
Route::post('/category/restore', 'CategoryController@restore')->name('category.restore');
Route::delete('/category/delete/permanent', 'CategoryController@delete')->name('category.delete');
Route::resource('category', 'CategoryController');

Route::get('/service/trashed', 'ServiceController@trashed')->name('service.trashed');
Route::post('/service/restore', 'ServiceController@restore')->name('service.restore');
Route::delete('/service/delete/permanent', 'ServiceController@delete')->name('service.delete');
Route::resource('service', 'ServiceController');

Route::get('/step/trashed', 'StepController@trashed')->name('step.trashed');
Route::post('/step/restore', 'StepController@restore')->name('step.restore');
Route::delete('/step/delete/permanent', 'StepController@delete')->name('step.delete');
Route::resource('step', 'StepController');

Route::get('/field/trashed', 'FieldController@trashed')->name('field.trashed');
Route::post('/field/restore', 'FieldController@restore')->name('field.restore');
Route::delete('/field/delete/permanent', 'FieldController@delete')->name('field.delete');
Route::resource('field', 'FieldController');

Route::get('/serviceorder/trashed', 'ServiceOrderController@trashed')->name('serviceorder.trashed');
Route::post('/serviceorder/restore', 'ServiceOrderController@restore')->name('serviceorder.restore');
Route::delete('/serviceorder/delete/permanent', 'ServiceOrderController@delete')->name('serviceorder.delete');
Route::resource('serviceorder', 'ServiceOrderController');

Route::get('/user/trashed', 'UserController@trashed')->name('user.trashed');
Route::post('/user/restore', 'UserController@restore')->name('user.restore');
Route::delete('/user/delete/permanent', 'UserController@delete')->name('user.delete');
Route::resource('user', 'UserController');

Route::resource('role', 'RoleController')->middleware('otp');
