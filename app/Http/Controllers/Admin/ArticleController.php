<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Article;
use App\Models\ArticleTag;

use Baijunyao\LaravelUpload\Upload;
use Illuminate\Http\Request;

use App\Http\Requests\Article\Store;



class ArticleController extends Controller
{
    //
    public function index()
    {
        $model = new Article();
        $article = $model->getLists();
//        dd($article);
        $assign = compact('article');
        return view('admin.article.index', $assign);
    }

    public function create()
    {
        //分类
        $category = Category::all();
        //标签
        $tag = Tag::all();
        //作者
        $author = Config('wublog.author');
//        $author = Config::where(['name'=>'author'])->value();
//        $author   = Config::where('name', 'AUTHOR')->value('value');

        $assgin = compact('category','tag', 'author');
//        dd($assgin);
        return view('admin.article.create', $assgin);
    }

    public function store(Store $request)
    {
        //获取出token外的所有数据
        $data = $request->except('_token');
        //判断是否上传图片，如果上传图片则把图片上传到本地，保存本地路劲
        if($request->hasFile('cover')){
            $result = Upload::file('cover', 'uploads/article');
            if($result['status_code'] === 200){
                $data['cover'] = $result['data'][0]['path'];
            }
        }
        //标签id
        $tag_ids = $data['tag_ids'];
        unset($data['tag_ids']);
//        dd($data);

        //添加文章
        $article = Article::create($data);
        if ($article){
            $articleTag = new ArticleTag();
            //批量上传标签id
            $articleTag->addTagIds($article->id, $tag_ids);
        }
        redirect('admin/article/index');
    }
}
