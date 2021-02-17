<?php

Route::redirect('/', '/admin/home');

Route::group(['middleware' => 'verified'], function () {
    Route::get('/home', 'DashboardController@index')->name('home');
});

Route::get('/page/trashed', 'PageController@trashed')->name('page.trashed');
Route::post('/page/restore', 'PageController@restore')->name('page.restore');
Route::delete('/page/delete/permanent', 'PageController@delete')->name('page.delete');
Route::resource('page', 'PageController');

Route::get('/business/trashed', 'BusinessController@trashed')->name('business.trashed');
Route::post('/business/restore', 'BusinessController@restore')->name('business.restore');
Route::delete('/business/delete/permanent', 'BusinessController@delete')->name('business.delete');
Route::resource('business', 'BusinessController');

Route::get('/code/trashed', 'CodeController@trashed')->name('code.trashed');
Route::post('/code/restore', 'CodeController@restore')->name('code.restore');
Route::delete('/code/delete/permanent', 'CodeController@delete')->name('code.delete');

Route::get('/code/claimed', 'CodeController@codeClaimed')->name('code.claimed');
Route::get('/code/pdf/{code}', 'CodeController@createPDF')->name('code.pdf');
Route::get('/code/batch', 'CodeController@showBatchForm')->name('code.batch');
Route::post('/code/batch', 'CodeController@updateBatch');

Route::resource('code', 'CodeController');


Route::get('/client/trashed', 'ClientController@trashed')->name('client.trashed');
Route::post('/client/restore', 'ClientController@restore')->name('client.restore');
Route::delete('/client/delete/permanent', 'ClientController@delete')->name('client.delete');
Route::resource('client', 'ClientController');

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
