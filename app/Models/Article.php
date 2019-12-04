<?php

namespace App\Models;


class Article extends Base
{

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


        //return self::with('category')->orderBy('created_at','desc')->simplePaginate('10');*/

    }
}
