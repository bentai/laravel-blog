<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Observers\CategoryObserver;
use App\Observers\TagObserver;
use App\Observers\ArticleObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
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
        //
        Tag::observe(TagObserver::class);
        Article::observe(ArticleObserver::class);
        Category::observe(CategoryObserver::class);

    }
}
