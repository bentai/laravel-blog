<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\Article;
class IndexController extends Controller
{

    public function index()
    {
        // 获取文章列表数据
        $articles = Article::select(
            'id', 'category_id', 'title',
            'slug', 'author', 'description',
            'cover', 'is_top', 'created_at'
        )
            ->orderBy('is_top', 'desc')
            ->orderBy('created_at', 'desc')
            ->with(['category', 'tag'])
            ->paginate(10);
//        dd($articles);
        $head = [
            'title'       => config('bjyblog.head.title'),
            'keywords'    => config('bjyblog.head.keywords'),
            'description' => config('bjyblog.head.description'),
        ];
        $assign = [
            'category_id'  => 'index',
            'articles'     => $articles,
            'head'         => $head,
            'tagName'      => '',
        ];
        return view('home.index.index', $assign);
//        return view('index.index');
    }
}
