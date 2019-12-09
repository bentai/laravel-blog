<?php

namespace App\Models;
use Laravel\Scout\Searchable;
use DB;
class Article extends Base
{
    use Searchable;


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tag()
    {
        return $this->belongsToMany(Tag::class,'article_tags','article_id', 'tag_id')->select(['id','name']);
    }

    public function categories(){
        return $this->hasOne(Categories::class,'id');
    }

//    public function search

    public  function getLists()
    {
        $wd = request()->input('wd', '')?: '';
        //获取查询id
        $id = self::searchArticleGetId($wd);
//        return $this->withTrashed()->with('category')->orderBy('created_at','desc')->simplePaginate(2);
        return $this->withTrashed()->with('category')
            ->when($wd, function($query) use ($id){
                return $query->whereIn('id', $id);
            })
            ->orderBy('created_at','desc')->paginate(2);
    }


    public static function searchArticleGetId(string $wd)
    {
        // 如果 SCOUT_DRIVER 为 null 则使用 sql 搜索
        if (env('SCOUT_DRIVER') === null) {
             return self::withTrashed()->where('title', 'like', "%$wd%")
                ->orWhere('description', 'like', "%$wd%")
                ->orWhere('markdown', 'like', "%$wd%")
                ->pluck('id');
        }

        // 如果全文搜索出错则降级使用 sql like
        /*try {
//            dd($wd);
            self::search($wd)->get();
        }catch(\Exception $e){
//            dd($e->getMessage());
            return self::where('title', 'like', "%$wd%")
                ->orWhere('description', 'like', "%$wd%")
                ->orWhere('markdown', 'like', "%$wd%")
                ->pluck('id');
        }*/
    }


}
