<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 登录页
Route::get('/admin', [
    'middleware'    => ['guest:admin'],
    'as'            => 'admin.login.page',
    'uses'          => 'AdminLoginController@showLoginForm'
]);
// 登录验证页
Route::post('/admin', [
    'middleware'    => ['guest:admin'], // 已经自带了 hasTooManyLoginAttempts
    'as'            => 'admin.login',
    'uses'          => 'AdminLoginController@login'
]);

// 后台功能
Route::group([
    'prefix' 		=> 'admin',
    'middleware'    => ['auth:admin']
], function () {
    // 后台首页
    Route::get('dashboard', [
        'as'			=> 'dashboard',
        'uses' 			=> 'DashboardController@index'
    ]);
});
