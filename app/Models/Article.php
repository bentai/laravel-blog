<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Str;

//use SoftDeletes;



class Article extends Model
{
    use SoftDeletes;

    //
    /*public function category()
    {
    //第二个参数是当前 表对应关联表id
        return $this->belongsTo(Category::class,'id');
    }*/

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories(){
        return $this->hasOne(Categories::class,'id');
    }

//    public function search

    public  function getLists()
    {
        return $this->withTrashed()->with('category')->orderBy('created_at','desc')->simplePaginate('10');
//        dd($data->toArray());
        /*return $data;

        return self::with('category')->orderBy('created_at','desc')->simplePaginate('10');*/

    }
}
