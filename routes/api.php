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

    Route::group(['middleware' => ['auth:api', 'check.auth']], function () {
        Route::post('/logout', 'Api\LoginController@logout')->name('admin.logout');

        Route::get('/user/info', 'Api\UserController@info')->name('user.info');
        Route::get('/user/menuIds', 'Api\UserController@menuIds')->name('user.menuIds');
        Route::get('/menu/tree', 'Api\MenuController@tree')->name('menu.tree');
        Route::get('/menu/apis', 'Api\MenuController@apis')->name('menu.apis');
        Route::post('/menu/addApis', 'Api\MenuController@addApis')->name('menu.addApis');
        Route::get('/api/tree', 'Api\ApiController@tree')->name('api.tree');
        Route::get('/role/menuIds', 'Api\RoleController@menuIds')->name('role.menuIds');
        Route::get('/role/kv', 'Api\RoleController@kv')->name('role.kv');

        Route::apiResources(array(
            '/user' => 'Api\UserController',
            '/api' => 'Api\ApiController',
            '/menu' => 'Api\MenuController',
            '/role' => 'Api\RoleController',
        ));
    });
});
