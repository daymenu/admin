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
        Route::post('/logout', 'Api\LoginController@logout')->name('admin.logout');
        
        Route::get('/user','Api\UserController@index')->name('user.index');
        Route::get('/user/show','Api\UserController@show')->name('user.show');
        Route::post('/user/store','Api\UserController@store')->name('user.store');
        Route::post('/user/update','Api\UserController@update')->name('user.update');
        Route::post('/user/destroy','Api\UserController@destroy')->name('user.destroy');
        Route::get('/user/info','Api\UserController@info')->name('user.info');
    });
});
