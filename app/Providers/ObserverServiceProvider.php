<?php

namespace App\Providers;

use App\Models\Tag;
use App\Observers\TagObserver;
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

    }
}
