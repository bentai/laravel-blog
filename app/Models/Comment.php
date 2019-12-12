<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\SocialiteUser;
class Comment extends Base
{
    // 关联文章
    public function article()
    {
        return $this->belongsTo(Article::class)->withDefault()->select(['id', 'title']);
    }

    // 关联第三方用户
    public function socialiteUser()
    {
        return $this->belongsTo(SocialiteUser::class)->withDefault()->select(['id', 'name']);
    }
}
