<?php

namespace App\Observers;
use App\Models\Article;

class CategoryObserver
{

    //
    public function saving($category)
    {
        if ($category->isDirty('name') && empty($category->slug)) {
            $category->slug = generate_english_slug($category->name);
        }
    }

    public function deleting($category)
    {
        if (Article::where('category_id', $category->id)->count() !== 0) {
            flash_error('请先删除此分类下的文章');
            return false;
        }
    }

    /*public function creating()
    {
        dd(222);
    }

    public function created()
    {
        dd(33);
    }*/

    public function created($model)
    {
        flash_success(__('Store Success'));
    }
}
