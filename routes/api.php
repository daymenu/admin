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

    Route::group(['middleware' => ['auth:api','check.auth']], function () {
        Route::post('/logout', 'Api\LoginController@logout')->name('admin.logout');

        Route::get('/user/info','Api\UserController@info')->name('user.info');
        Route::get('/menu/select','Api\MenuController@menuSelect')->name('menu.select');
        
        Route::apiResources(array(
            '/user' => 'Api\UserController',
            '/api' => 'Api\ApiController',
            '/menu' => 'Api\MenuController',
        ));
    });
});
