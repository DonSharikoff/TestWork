<?php

use Illuminate\Http\Request;

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

Route::group( ['prefix' => 'v1'], function () {

    Route::post('login', 'Auth\LoginController@auth')->name('auth:api');
    Route::post('registration', 'Auth\RegisterController@register')->name('registration');
    Route::post('logout', 'Auth\LoginController@logout')->middleware('auth:api')->name('logout');

    Route::group( ['prefix' => 'user', 'middleware' => 'auth:api'], function () {
        Route::get('get', 'UserController@user')->name('user::get');
        Route::get('all', 'UserController@all')->name('user::all');

        Route::post('info', 'UserController@userUpdate')->name('user::userUpdate');
        Route::post('img', 'UserController@imgUpdate')->name('user::imgUpdate');
    });
    Route::group( ['prefix' => 'likes', 'middleware' => 'auth:api'], function () {
        Route::get('user', 'LikesController@user')->name('likes::user');

        Route::post('save', 'LikesController@save')->name('likes::save');
    });
});
