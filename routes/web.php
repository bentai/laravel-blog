<?php

// Home 模块
Route::namespace('Home')->group(function () {
    // 首页
    Route::get('/', 'IndexController@index');

    // 文章
    Route::get('article/{id}','IndexController@article');
    // 分类列表
    Route::get('category/{id}','IndexController@category');
    // 随言碎语列表
    Route::get('note','IndexController@note');
    // 开源项目
    Route::get('git','IndexController@git');
    // 标签列表
    Route::get('tag/{id}','IndexController@tag');
    // search
    Route::get('search','IndexController@search');
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
        //批量替换功能视图
        Route::get('replaceView', 'ArticleController@replaceView');
        // 批量替换
        Route::post('replace', 'ArticleController@replace');
    });

    // 分类控制器
    Route::prefix('category')->group(function () {
        // 分类列表
        Route::get('index', 'CategoryController@index');
        // 添加分类
        Route::get('create', 'CategoryController@create');
        // 保存分类
        Route::post('store', 'CategoryController@store');
        // 编辑分类
//        Route::get('edit/{id}', 'CategoryController@edit');
        Route::get('edit/{id}', 'CategoryController@edit');
        // 更新分类
        Route::post('update/{id}', 'CategoryController@update');
        // 保存排序
        Route::post('sort', 'CategoryController@sort');
        Route::get('destroy/{id}', 'CategoryController@destroy');
        Route::get('restore/{id}', 'CategoryController@restore');
        Route::get('forceDelete/{id}', 'CategoryController@forceDelete');
    });

    Route::prefix('nav')->group(function () {
        // 导航列表
        Route::get('index', 'NavController@index');
        // 添加导航
        Route::get('create', 'NavController@create');
        // 保存导航
        Route::post('store', 'NavController@store');
        // 编辑导航
//        Route::get('edit/{id}', 'NavController@edit');
        Route::get('edit/{id}', 'NavController@edit');
        // 更新导航
        Route::post('update/{id}', 'NavController@update');
        // 保存排序
        Route::post('sort', 'NavController@sort');
        Route::get('destroy/{id}', 'NavController@destroy');
        Route::get('restore/{id}', 'NavController@restore');
        Route::get('forceDelete/{id}', 'NavController@forceDelete');
    });

        // 标签控制器
    Route::prefix('tag')->group(function (){
        // 标签列表
        Route::get('index', 'TagController@index');
        // 添加标签
        Route::get('create', 'TagController@create');
        // 保存标签
        Route::post('store', 'TagController@store');
        // 编辑标签
//        Route::get('edit/{id}', 'TagController@edit');
        Route::get('edit/{id}', 'TagController@edit');
        // 更新标签
        Route::post('update/{id}', 'TagController@update');
        // 保存排序
        Route::post('sort', 'TagController@sort');
        Route::get('destroy/{id}', 'TagController@destroy');
        Route::get('restore/{id}', 'TagController@restore');
        Route::get('forceDelete/{id}', 'TagController@forceDelete');
    });

    //评价模块
    Route::prefix('comment')->group(function (){
        //评价列表
        Route::get('index', 'CommentController@index');
        // 发布评价
        Route::get('create', 'CommentController@create');
        //新建评价
//        Route::post('store', 'CommentController@store');
        Route::post('store', 'CommentController@store');
        //编辑评价
        Route::get('edit/{id}', 'CommentController@edit');
        Route::post('update/{id}', 'CommentController@update');
        //删除评价
        Route::get('destroy/{id}', 'CommentController@destroy');
        //恢复删除评价
        Route::get('restore/{id}', 'CommentController@restore');
        //彻底删除评价
        Route::get('forceDelete/{id}', 'CommentController@forceDelete');
        //批量替换功能视图
        Route::get('replaceView', 'CommentController@replaceView');
        // 批量替换
        Route::post('replace', 'CommentController@replace');
    });

    // 管理员
    Route::prefix('user')->group(function () {
        // 管理员列表
        Route::get('index', 'UserController@index');
        // 编辑管理员
        Route::get('edit/{id}', 'UserController@edit');
        Route::post('update/{id}', 'UserController@update');
        // 删除管理员
        Route::get('destroy/{id}', 'UserController@destroy');
        // 恢复删除的管理员
        Route::get('restore/{id}', 'UserController@restore');
        // 彻底删除管理员
        Route::get('forceDelete/{id}', 'UserController@forceDelete');
    });




    // 友情链接管理
    Route::prefix('friendshipLink')->group(function () {
        // 友情链接列表
        Route::get('index', 'FriendshipLinkController@index');
        // 添加友情链接
        Route::get('create', 'FriendshipLinkController@create');
        Route::post('store', 'FriendshipLinkController@store');
        // 编辑友情链接
        Route::get('edit/{id}', 'FriendshipLinkController@edit');
        Route::post('update/{id}', 'FriendshipLinkController@update');
        // 排序
        Route::post('sort', 'FriendshipLinkController@sort');
        // 删除友情链接
        Route::get('destroy/{id}', 'FriendshipLinkController@destroy');
        // 恢复删除的友情链接
        Route::get('restore/{id}', 'FriendshipLinkController@restore');
        // 彻底删除友情链接
        Route::get('forceDelete/{id}', 'FriendshipLinkController@forceDelete');
    });

    // 推荐博客管理
    Route::prefix('site')->group(function () {
        // 推荐博客列表
        Route::get('index', 'SiteController@index');
        // 添加推荐博客
        Route::get('create', 'SiteController@create');
        Route::post('store', 'SiteController@store');
        // 编辑推荐博客
        Route::get('edit/{id}', 'SiteController@edit');
        Route::post('update/{id}', 'SiteController@update');
        // 排序
        Route::post('sort', 'SiteController@sort');
        // 删除推荐博客
        Route::get('destroy/{id}', 'SiteController@destroy');
        // 恢复删除的推荐博客
        Route::get('restore/{id}', 'SiteController@restore');
        // 彻底删除推荐博客
        Route::get('forceDelete/{id}', 'SiteController@forceDelete');
    });

    // 随言碎语管理
    Route::prefix('note')->group(function () {
        // 随言碎语列表
        Route::get('index', 'NoteController@index');
        // 添加随言碎语
        Route::get('create', 'NoteController@create');
        Route::post('store', 'NoteController@store');
        // 编辑随言碎语
        Route::get('edit/{id}', 'NoteController@edit');
        Route::post('update/{id}', 'NoteController@update');
        // 删除随言碎语
        Route::get('destroy/{id}', 'NoteController@destroy');
        // 恢复删除的随言碎语
        Route::get('restore/{id}', 'NoteController@restore');
        // 彻底删除随言碎语
        Route::get('forceDelete/{id}', 'NoteController@forceDelete');
    });

    // 系统设置
    Route::prefix('config')->group(function () {

        // 编辑邮箱配置页面
        Route::get('email', 'ConfigController@email');
        //  Comment Audit
        Route::get('commentAudit', 'ConfigController@commentAudit');
        // 编辑备份配置页面
        Route::get('backup', 'ConfigController@backup');
        // SEO
        Route::get('seo', 'ConfigController@seo');
        // 编辑 qq 群配置页面
        Route::get('qqQun', 'ConfigController@qqQun');
        // Social Share
        Route::get('socialShare', 'ConfigController@socialShare');
        // 编辑配置项页面
        Route::get('edit', 'ConfigController@edit');
        Route::get('clear', 'ConfigController@clear');

        // 保存数据
        Route::post('update', 'ConfigController@update');
    });

    // 开源项目管理
    Route::prefix('gitProject')->group(function () {
        // 开源项目列表
        Route::get('index', 'GitProjectController@index');
        // 添加开源项目
        Route::get('create', 'GitProjectController@create');
        Route::post('store', 'GitProjectController@store');
        // 编辑开源项目
        Route::get('edit/{id}', 'GitProjectController@edit');
        Route::post('update/{id}', 'GitProjectController@update');
        // 排序
        Route::post('sort', 'GitProjectController@sort');
        // 删除开源项目
        Route::get('destroy/{id}', 'GitProjectController@destroy');
        // 恢复删除的开源项目
        Route::get('restore/{id}', 'GitProjectController@restore');
        // 彻底删除开源项目
        Route::get('forceDelete/{id}', 'GitProjectController@forceDelete');
    });

});

