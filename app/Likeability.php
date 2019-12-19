<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait Likeability
{


    public function like()
    {
        $like = new Like([
            'user_id' => Auth::id()
        ]);
        $this->likes()->save($like);
    }

    public function unlike()
    {
        $this->likes()
            ->where(['user_id' => Auth::id()])
            ->delete();
    }

    public function toggle()
    {
        if(!$this->isLiked()){
            return $this->like();
        }
        return $this->unlike();

    }

    public function likesCount()
    {
        return $this->likes()->count();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function isLiked()
    {
        return $this->likes()->where(['user_id' => Auth::id()])->exists();
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

}


