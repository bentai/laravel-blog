<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class Tag extends Base
{
    use SoftDeletes;
    //
    protected $fillable = ['name'];

    // 多对多关联  关联文章表
    public function article()
    {
        return $this->belongsToMany(Article::class, 'article_tags');
    }

    //获取属于当前标签的文章
    public function getArticlesCountAttribute()
    {
//        $parameters = [$this->id];
        return $this->with('article')->count('id');
    }
    //获取前台链接
    public function getUrlAttribute()
    {
        $parameters = [$this->id];
        if (Str::isTrue(config('bjyblog.seo.use_sulg'))) {
            $parameters[] = $this->slug;
        }
        return url('tag',$parameters);
    }
}
