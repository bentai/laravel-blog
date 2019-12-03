<?php

namespace App\Observers;


class TagObserver
{
    //
    public function saving($category)
    {
        if ($category->isDirty('name') && empty($category->slug)) {
            $category->slug = generate_english_slug($category->name);
        }
    }

    public function creating()
    {
        dd(222);
    }

    public function created()
    {
        dd(33);
    }
}
