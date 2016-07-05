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

Route::group(['middleware' => 'before'], function() {
    Route::get('/', 'HomeController@index');

    Route::auth();

    Route::get('/redirect', 'SocialAuthController@redirect');
    Route::get('/callback', 'SocialAuthController@callback');

    //Route::get('/home', 'HomeController@index');
    Route::get('get-subcategories', 'AdminQuizzesController@getSubCategories');
    Route::get('get-template-details', 'AdminQuizzesController@getTemplateDetails');
    Route::get('get-quiz-form', 'AdminQuizzesController@getQuizForm');

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
            Route::post('users/block/{id}', 'AdminUsersController@block');
            Route::post('users/download-csv', 'AdminUsersController@exportToCsv');
            Route::resource('category', 'AdminCategoriesController');
            Route::resource('sub-category', 'AdminSubCategoriesController');
            Route::resource('quiz', 'AdminQuizzesController');
            Route::post('save-template-image', 'AdminQuizTemplatesController@saveTemplateImage');
            Route::resource('layout', 'AdminQuizTemplatesController');
            Route::get('language', 'AdminController@getLanguage');
            Route::post('language', 'AdminController@postLanguage');
            Route::post('language/{id}', 'AdminController@postUpdateLanguage');
            Route::get('get-language-form', 'AdminController@getLanguageForm');
        });
    });

    Route::group(['prefix' => 'quiz'], function() {
        Route::get('{categorySlug}/{quizSlug}', 'QuizzesController@index')->middleware(['auth']);
        Route::get('{quizSlug}/start', 'QuizzesController@start')->middleware(['auth']);
    });
});
