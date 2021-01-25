<?php

Route::redirect('/home', '/demo/projects')->name('home');

Route::name('frontend.')->group(function () {
    Route::resource('services', 'ServiceController');
    Route::get('/services/{service}/order', 'ServiceController@order')->name('services.order');
});

Route::name('frontend.')->middleware(['auth'])->group(function () {
    Route::resource('serviceorder', 'ServiceOrderController');
});

Route::name('frontend.')->middleware(['auth'])->group(function () {
    // Route::resource('page', 'PageController'); // TODO: Create Controller to manage viewing of Page in frontend.
});

Route::prefix('demo')->name('demo')->group(function () {
    Route::view('/create-project', 'frontend.projects.create.index')->name('create');
    Route::view('/project-dashboard', 'frontend.projects.tabs.index')->name('dash');
});

Route::group(['middleware' => 'verified'], function () {
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
