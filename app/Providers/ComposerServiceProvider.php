<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Config;
use App\Models\FriendshipLink;
use App\Models\Nav;
use App\Models\Note;
use App\Models\SocialiteUser;
use App\Models\Tag;
use App\Models\GitProject;
use Illuminate\Support\ServiceProvider;

use Exception;
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 查看是否有配置信息
        try {
            $config = Config::where('id','>','100')->pluck('value','name');
        } catch(Exception $exception) {
            return true;
        }
//        dd($config->toArray());
        // 动态配置 /config 目录下的配置项
        config($config->toArray());
//        $data = $config->toArray();
//        $data['backup.backup.destination.disks'] = [];
//        dd($data['backup.backup.destination.disks']);
        // 开源项目数据
        view()->composer(['layouts/home', 'home/index/git'], function ($view) {
            $gitProject = GitProject::select('name', 'type')->orderBy('sort')->get();
            // 分配数据
            $view->with(compact('gitProject'));
        });
        //分配前台初始数据
        view()->composer('layouts/home', function ($view) {
            //分类
            $category   = Category::get();
            $nav        = Nav::get();
            $tag        = Tag::get();
            $topArticle = Article::get();
            $friendshipLink = FriendshipLink::get();
            $view->with(compact('category','nav', 'tag', 'topArticle', 'friendshipLink'));
        });
        // 获取后台首页统计数据
        view()->composer(['layouts/home', 'admin.index.index'], function ($view) {
            // 文章总数
            $articleCount = Article::count('id');
            // 评论总数
            $commentCount = Comment::count('id');
            // 随言碎语总数
            $chatCount = Note::count('id');
            // 第三方用户总数
            $socialiteUserCount = SocialiteUser::count('id');
            $view->with(compact('articleCount','commentCount', 'chatCount', 'socialiteUserCount'));
        });
        view()->composer('admin.config.*', function ($view) use ($config) {
            $view->with(compact('config'));
        });

    }
}
