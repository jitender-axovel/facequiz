<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

//Route::get('/home', 'HomeController@index');
Route::get('get-subcategories', 'AdminQuizzesController@getSubCategories');

Route::group(['prefix' => 'admin'], function() {
	Route::get('login', 'AdminController@getLogin');
	Route::post('login', 'AdminController@postLogin');
	Route::group(['middleware' => ['auth', 'admin']], function() {
		Route::get('dashboard', 'AdminController@getDashboard');
		Route::get('users', 'AdminUsersController@index');
		Route::get('users/edit/{id}', 'AdminUsersController@getEdit');
		Route::post('users/edit/{id}', 'AdminUsersController@postEdit');
		Route::get('users/view/{id}', 'AdminUsersController@view');
		Route::delete('users/delete/{id}', 'AdminUsersController@delete');
		Route::resource('category', 'AdminCategoriesController');
		Route::resource('sub-category', 'AdminSubCategoriesController');
		Route::resource('quiz', 'AdminQuizzesController');
	});
});