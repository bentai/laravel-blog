<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ArticleTag extends Base
{
    //
//    protected $fillable = ['name'];
    public function addTagIds(int $article_id, array $tag_ids)
    {
        $data = array_map(function($tag) use ($article_id){
            return [
                'article_id' => $article_id,
                'tag_id'        => $tag,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        },$tag_ids);
        return $this->insert($data);
    }
}
