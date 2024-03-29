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
\DB::enableQueryLog();

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
    // 'middleware'    => ['auth:admin']
    'middleware'    => ['auth:admin', 'checkPermission']
], function () {
    // 后台首页
    Route::get('dashboard', [
        'as'			=> 'dashboard',
        'uses' 			=> 'DashboardController@index'
    ]);

    // 管理员
    Route::get('admins/search', 'AdminController@search')->name('admins.search');
    Route::resource('admins', 'AdminController', ['only' => [
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]]);

    // 管理员状态
    Route::get('profile', 'AdminController@profile')->name('admin.profile');
    Route::put('profile', 'AdminController@updateProfile')->name('admin.update.profile');
    Route::post('logout', 'AdminLoginController@logout')->name('admin.logout');

    // 角色
    Route::resource('roles', 'RoleController', ['only' => [
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]]);

    // 权限
    Route::resource('permissions', 'PermissionController', ['only' => [
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]]);

    // 地址
    Route::get('regions', 'RegionController@index')->name('regions.index');
    Route::get('regions/list', 'RegionController@list')->name('regions.list');

    // 设置
    Route::get('setting', 'SettingController@index')->name('setting.index');

    // 图片
    Route::get('image/search', 'ImageController@search')->name('image.search');
    Route::resource('image', 'ImageController', ['only' => [
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]]);

    // banner
    Route::resource('banner', 'BannerController', ['only' => [
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]]);
});
