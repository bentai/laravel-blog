<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Config;


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
}
