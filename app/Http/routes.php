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
Route::get('/callback', 'SocialAuthController@callback');
Route::group(['middleware' => 'before'], function () {

    Route::get('/', 'HomeController@index');

    Route::auth();

    Route::get('/redirect', 'SocialAuthController@redirect');

    Route::get('cms/{slug}', 'CmsController@getPage');

    Route::get('quizzes/latest', 'QuizzesController@getLatestQuizzes');

    Route::get('get-template-details', 'AdminQuizzesController@getTemplateDetails');

    Route::group(['prefix' => 'quiz'], function() {
        Route::get('{quizSlug}/show', 'QuizzesController@index');
        Route::get('{quizSlug}/landing/{userId}/{version}', 'QuizzesController@landing');
        Route::get('{quizSlug}/start/{version}', 'QuizzesController@start')->middleware(['auth']);
        Route::get('{quizSlug}/share/{userId}', 'QuizzesController@share');
        Route::get('{quizSlug}/summary', 'QuizzesController@summary');
    });

});

Route::get('get-widget-form/{slug}', function($slug) {
    return view('admin.widgets.components.widget-form', compact('slug'));
});

Route::get('get-quiz-fact', function() {
    return view('admin.quizzes.quiz-fact');
});

Route::delete('revoke', 'HomeController@revokePermissions')->middleware('auth');

Route::group(['prefix' => 'admin'], function() {
    Route::get('login', 'AdminController@getLogin');
    Route::post('login', 'AdminController@postLogin');
    Route::group(['middleware' => ['admin']], function() {
        Route::get('dashboard', 'AdminController@getDashboard');
        Route::get('users', 'AdminUsersController@index');
        Route::get('users/edit/{id}', 'AdminUsersController@getEdit');
        Route::post('users/edit/{id}', 'AdminUsersController@postEdit');
        Route::get('users/view/{id}', 'AdminUsersController@view');
        Route::delete('users/delete/{id}', 'AdminUsersController@delete');
        Route::post('users/block/{id}', 'AdminUsersController@block');
        Route::post('users/download-csv', 'AdminUsersController@exportToCsv');
        Route::post('quiz/change-status/{id}', 'AdminQuizzesController@changeStatus');
        Route::resource('quiz', 'AdminQuizzesController');
        Route::resource('layout', 'AdminQuizTemplatesController');
        Route::resource('widget', 'AdminWidgetsController');
        Route::resource('cms', 'AdminCmsController');
        Route::get('language', 'AdminController@getLanguage');
        Route::post('language', 'AdminController@postLanguage');
        Route::post('language/{id}', 'AdminController@postUpdateLanguage');
        Route::get('language/{id}/order/{status}', 'AdminController@changeLanguageOrder');
        Route::delete('language/{id}/delete', 'AdminController@deleteLanguage');
        Route::get('get-language-form', 'AdminController@getLanguageForm');
    });
});