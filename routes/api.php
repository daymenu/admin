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


Route::get('/nologin', function () {
    return ['code' => 100010, 'msg' => '请重新登录'];
})->name('nologin');

Route::group(['prefix' => 'admin'], function () {

    Route::post('/login', 'Api\LoginController@index')->name('admin.login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user/info', 'Api\UserController@info')->name('admin.user.info');
    });
});
