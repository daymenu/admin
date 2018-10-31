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

Route::group(['prefix' => 'v1'], function () {

    Route::post('/login', 'Api\LoginController@index');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user', function (Request $request) {
            return ['dfd'];
        });
    });
});
