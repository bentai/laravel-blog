<?php

namespace App\Models;
use Laravel\Scout\Searchable;
use DB;
class Article extends Base
{
    use Searchable;

    /**
     * 索引的字段
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only('id', 'title', 'content');
    }


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


    /**
     * 过滤描述中的换行。
     *
     * @param string $value
     *
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        return str_replace(["\r", "\n", "\r\n"], '', $value);
    }

    /**
     * @param $value
     *
     * @return mixed
     *
     * @author hanmeimei
     */
    public function getHtmlAttribute($value)
    {
        return str_replace('<img src="/uploads/article', '<img src="' . cdn_url('uploads/article'), $value);
    }

//    public function search

    public  function getLists()
    {
        $wd = request()->input('wd', '')?: '';
        //获取查询id
        $id = self::searchArticleGetId($wd);
//        dd($id);
//        return $this->withTrashed()->with('category')->orderBy('created_at','desc')->simplePaginate(2);
        return $this->withTrashed()->with('category')
            ->when($wd, function($query) use ($id){
                return $query->whereIn('id', $id);
            })
            ->orderBy('created_at','desc')->paginate(15);
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
        try {
            $id = self::search($wd)->keys();
        }catch(\Exception $e){
            $id = self::where('title', 'like', "%$wd%")
                ->orWhere('description', 'like', "%$wd%")
                ->orWhere('markdown', 'like', "%$wd%")
                ->pluck('id');
        }
        return $id;
    }

    /**
     * 给文章的插图添加水印;并取第一张图片作为封面图
     *
     * @param string $content markdown格式的文章内容
     * @param array  $except  忽略加水印的图片
     *
     * @return string
     */
    public function getCover(string $content, array $except = [])
    {
        // 获取文章中的全部图片
        preg_match_all('/!\[.*?\]\((\S*(?<=png|gif|jpg|jpeg)).*?\)/i', $content, $images);

        if (!empty($images[1])) {
            // 循环给图片添加水印
            foreach ($images[1] as $k => $v) {
                $image = explode(' ', $v);
                $file  = public_path() . $image[0];

                if (file_exists($file) && !in_array($v, $except)) {
                    add_text_water($file, config('bjyblog.water.text'));
                }

                // 取第一张图片作为封面图
                if ($k == 0) {
                    $cover = $image[0];
                }
            }
        }

        return $cover ?? 'uploads/article/default.jpg';
    }


}
