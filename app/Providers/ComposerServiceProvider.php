<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Config;
use App\Models\Note;
use App\Models\SocialiteUser;
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
        // 获取后台首页统计数据
        view()->composer(['admin.index.index'], function ($view) {
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
