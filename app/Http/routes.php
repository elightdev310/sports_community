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

/* ================== Homepage + Admin Routes ================== */
require __DIR__.'/admin_routes.php';
require __DIR__.'/sc_routes.php';
require __DIR__.'/scadmin_routes.php';

/* ============================================================= */
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [
        'as' => 'user.login', 'uses' => 'Auth\SCAuthController@loginPage' ]);
    Route::post('login', [
        'as' => 'user.login.post', 'uses' => 'Auth\SCAuthController@loginPost' ]);
    Route::get('signup', [
        'as' => 'user.signup', 'uses' => 'Auth\SCAuthController@signUpPage' ]);
    Route::post('signup', [
        'as' => 'user.signup.post', 'uses' => 'Auth\SCAuthController@signUpPost' ]);
});


Route::get('activate', [
    'as' => 'user.activate', 'uses' => 'Auth\SCActivationController@promptActivationCodePage' ]);
Route::post('activate', [
    'as' => 'user.activate.post', 'uses' => 'Auth\SCActivationController@activateUserPost' ]);
Route::get('send-activation', [
    'as' => 'user.activate.send', 'uses' => 'Auth\SCActivationController@sendActivationCode' ]);

Route::get('password/set', [
    'as' => 'user.password.set', 'uses' => 'Auth\SCAuthController@setPasswordPage' ]);
Route::post('password/set', [
    'as' => 'user.password.set.post', 'uses' => 'Auth\SCAuthController@setPasswordPost' ]);


// OAuth Routes
Route::get('auth/{provider}', 'Auth\SCAuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\SCAuthController@handleProviderCallback');
