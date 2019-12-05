<?php

// Home 模块
Route::namespace('Home')->group(function () {
    // 首页
    Route::get('/', 'IndexController@index');

});





// Auth
Route::namespace('Auth')->prefix('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        // 后台登录
        Route::post('login','AdminController@login');
        //退出登录
        Route::get('logout','AdminController@logout');
    });
});

// 后台登录页面
Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::redirect('/', url('/admin/login/index'));
    Route::prefix('login')->group(function () {
        // 登陆页面  增加中间件跳转
        Route::get('index', 'LoginController@index')->middleware('admin.login');
        //退出登录
        Route::get('logout','LoginController@logout');
    });
});

// Admin 模块
Route::namespace('Admin')->prefix('admin')->middleware('admin.auth')->group(function () {
    // 首页控制器
    Route::prefix('index')->group(function () {
        // 后台首页
        Route::get('index', 'IndexController@index');
    });
    //文章控制器
    Route::prefix('article')->group(function (){
        //文章列表
        Route::get('index', 'ArticleController@index');
        // 发布文章
        Route::get('create', 'ArticleController@create');
        //新建文章
//        Route::post('store', 'ArticleController@store');
        Route::post('store', 'ArticleController@store');
        //编辑文章
        Route::get('edit/{id}', 'ArticleController@edit');
        Route::post('update/{id}', 'ArticleController@update');
        //删除文章
        Route::get('destroy/{id}', 'ArticleController@destroy');
        //恢复删除文章
        Route::get('restore/{id}', 'ArticleController@restore');
        //彻底删除文章
        Route::get('forceDelete/{id}', 'ArticleController@forceDelete');




        /*Route::post('store', function()
        {
            dd(111);
        });*/

    });

    // 标签控制器
    Route::prefix('tag')->group(function (){
        //添加标签
        Route::post('store','TagController@store');
    });

});

