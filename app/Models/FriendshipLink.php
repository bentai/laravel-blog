<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendshipLink extends Base
{
    //
    public function setSortAttribute($value)
    {
        $this->attributes['sort'] = empty($value) ? null : $value;
    }

    /**
     * 给url添加 http 或者删除 /
     *
     * @author hanmeimei
     */
    public function setUrlAttribute(string $value)
    {
        $this->attributes['url'] = format_url($value);
    }
}
