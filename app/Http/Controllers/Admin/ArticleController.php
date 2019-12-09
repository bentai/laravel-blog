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

    public function store(Store $request, Article $articleModel)
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
        return redirect('admin/article/index');
    }


    public function edit($id)
    {
//        $article = Article::with('tag')->find($id)->toArray();
        $article          = Article::withTrashed()->find($id);
        $article->tag_ids = ArticleTag::where('article_id', $id)->pluck('tag_id')->toArray();
        //分类
        $category         = Category::all();
        //标签
        $tag              = Tag::all();

//        $author = Config::where(['name'=>'author'])->value();
//        $author   = Config::where('name', 'AUTHOR')->value('value');

        $assgin = compact('category','tag', 'article');
        return view('admin.article.edit', $assgin);
    }

    public function update(Store $request, Article $articleModel,ArticleTag $articleTagModel, $id)
    {
        $data = $request->except('_token');
        if($request->hasFile('cover')){
            $result = Upload::file('cover','uploads/article');
            if($result['code'] === 200){
                $data['cover'] = $result['data'][0]['path'];
            }
        }

        $tag_ids = $data['tag_ids'];
        unset($data['tag_ids']);
        $article = Article::withTrashed()->find($id)->update($data);
        if($article){
            //删除之前关联标签
            ArticleTag::where(['article_id'=>$id])->forceDelete();
            $articleTagModel->addTagIds($id, $tag_ids);
        }
        return redirect()->back();
    }

    /**
     * 删除文章
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Article $articleModel, $id)
    {
        $articleModel->destroy($id);
        return redirect()->back();
    }

    /**
     * 恢复删除文章
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore(Article $articleModel, $id)
    {
        $articleModel->onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }


    /**
     * 恢复删除文章
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function forceDelete(Article $articleModel, ArticleTag $articleTagModel, $id)
    {
        $articleModel->onlyTrashed()->find($id)->forceDelete();
        $articleTagModel->where(['article_id'=>$id])->forceDelete();
        return redirect()->back();
    }

    /**
     * 批量替换功能视图
     *
     * @return \Illuminate\View\View
     */
    public function replaceView()
    {
        return view('admin/article/replaceView');
    }

    /**
     * 批量替换功能
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replace(Request $request, Article $articleModel)
    {
        $search  = $request->input('search');
        $replace = $request->input('replace');
        $data    = Article::select('id', 'title', 'keywords', 'description', 'markdown', 'html')
            ->where('title', 'like', "%$search%")
            ->orWhere('keywords', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->orWhere('markdown', 'like', "%$search%")
            ->orWhere('html', 'like', "%$search%")
            ->get();
        foreach ($data as $k => $v) {
            Article::find($v->id)->update([
                'title'       => str_replace($search, $replace, $v->title),
                'keywords'    => str_replace($search, $replace, $v->keywords),
                'description' => str_replace($search, $replace, $v->description),
                'markdown'    => str_replace($search, $replace, $v->markdown),
                'html'        => str_replace($search, $replace, $v->html),
            ]);
        }

        return redirect()->back();


    }


}
