<?php

namespace App\Observers;

use Markdown;
class ArticleObserver
{

    //
    public function saving($article)
    {
        //描述 description  如果为空  从content 中取前300个字
        if(empty($article->description)){
            $article->description = preg_replace(
                ['/[~*>#-]*/', '/!?\[.*\]\(.*\)/', '/\[.*\]/'],
                '',
                $article->markdown
            );
        }
        if ($article->isDirty('title') && empty($article->slug)) {
            $article->slug = generate_english_slug($article->title);
        }

        $article->html = Markdown::convertToHtml($article->markdown);
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
