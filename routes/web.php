<?php

// Home 模块
Route::namespace('Home')->group(function () {
    // 首页
    Route::get('/', 'IndexController@index');

});


// 后台登录页面
Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::redirect('/', url('/admin/login/index'));
    Route::prefix('login')->group(function () {
        // 登录页面
//        Route::get('index', 'LoginController@index');
        //增加中间件跳转
        Route::get('index', 'LoginController@index')->middleware('admin.login');
//        Route::get('index', 'LoginController@index')->middleware('admin.login');
        // 退出
    });
});


Route::namespace('Auth')->prefix('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::post('login','AdminController@login');
        Route::get('logout','AdminController@logout');
        // 后台登录
        /*Route::post('login', function () {
            dd(1213);
        });*/

        /*Route::post('login',function() {
        });*/
    });

});
Route::namespace('Admin')->prefix('admin')->middleware('admin.auth')->group(function () {
    // 首页控制器
    Route::prefix('index')->group(function () {
        Route::get('index', function (){
            dd('adfadsflkajdhlkadhf');
        });
    });

});

