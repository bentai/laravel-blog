<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GitProject;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Note;
use Illuminate\Http\Request;
use Cache;
use Illuminate\Support\Facades\URL;
class IndexController extends Controller
{

    public function index()
    {
        dd(URL::signedRoute('home.git', ['user' => 1]));
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

    // 文章详情
    public function article($id,Request $request, Article $article)
    {
        $article = Article::with(['category','tag'])->where(['id'=>$id])->first();
        // 增加点击量
        // 获取当前用户
        $ipAndId = 'articleRequestList' . $request->ip() . ':' . $id;
        if (!Cache::has($ipAndId)){
            //设置缓存过期
            cache([$ipAndId => ''], 1440);
            // 文章点击加1
            $article->increment('click');
        }
        $prev = Article::select(['id', 'title', 'slug'])
            ->where('id', '<', $id)
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();
        $next = Article::select(['id', 'title', 'slug'])
            ->where('id', '>', $id)
            ->orderBy('created_at', 'asc')
            ->limit(1)
            ->first();
//        $comment = Comment::with('article')->where()->first();
        $category_id = $article->category->id;
        return view('home.index.article', compact('article', 'prev', 'next', 'category_id'));
    }

    // 分类列表
    public function category($id)
    {
        $category = Category::select(['id', 'name', 'keywords', 'description'])->findOrFail($id);
        // 文章列表
        // 获取分类下的文章
        $articles = $category->articles()
            ->with('tag')
            ->orderBy('is_top', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        if ($articles->isNotEmpty()) {
            $articles->setCollection(
                collect(
                    $articles->items()
                )->map(function ($v) use ($category) {
                    $v->category = $category;

                    return $v;
                })
            );
        }
        $head = [
            'title'       => $category->name,
            'keywords'    => $category->keywords,
            'description' => $category->description,
        ];
        $category_id = $category->id;
        $tagNmae = '';

        return view('home.index.index', compact('articles', 'head', 'category_id', 'tagNmae'));
    }

    public function note()
    {
        return view('home.index.note', [
            'category_id' => 'note',
            'notes'        => Note::orderBy('created_at', 'desc')->get(),
            'title'       => '随言碎语'
        ]);
    }

    public function git()
    {
        return view('home.index.git', [
            'category_id' => 'git',
            'title'       => '开源项目'
        ]);
    }

    public function tag($id)
    {
        $tag = Tag::select('id', 'name', 'keywords', 'description')->findOrFail($id);

        $articles = $tag->article()->with(['category', 'tag'])
            ->orderBy('is_top', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $head = [
            'title'       => $tag->title,
            'keywords'    => $tag->keywords,
            'description' => $tag->description,
        ];
        return view('home.index.index',[
            'category_id' => 'index',
            'articles'    => $articles,
            'head' => $head,
            'tagName' => $tag->name,
            'title' => $tag->name,
        ]);
    }

    public function search(Request $request, Article $articleModel)
    {
        $wd = $request->input('wd');
        $ids = $articleModel::searchArticleGetId($wd);

        $article = $articleModel::select('id', 'category_id', 'title',
            'author', 'description', 'cover',
            'is_top', 'created_at')
            ->whereIn('id', $ids)
            ->with(['category', 'tag'])
            ->orderBy('is_top', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $head = [
            'title'       => $wd,
            'keywords'    => '',
            'description' => '',
        ];
        return response()->view('home.index.index', [
            'category_id' => 'index',
            'articles'     => $article,
            'tagName'     => '',
            'title'       => $wd,
            'head'        => $head
        ])->header('X-Robots-Tag', 'noindex');
    }
}
