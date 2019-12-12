<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Base
{
    //
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = format_url($value);
    }
}
