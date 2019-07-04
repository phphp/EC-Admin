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

Route::get('/admin', [
    'middleware'    => ['guest:admin'],
    'as'            => 'admin.login.page',
    'uses'          => 'AdminLoginController@showLoginForm'
]);
Route::post('/admin', [
    'middleware'    => ['guest:admin'], // 已经自带了 hasTooManyLoginAttempts
    'as'            => 'admin.login',
    'uses'          => 'AdminLoginController@login'
]);


Route::get('/dashboard', [
    'middleware'    => ['auth:admin'],
    'as'            => 'dashboard',
    'uses'          => 'DashboardController@index'
]);
