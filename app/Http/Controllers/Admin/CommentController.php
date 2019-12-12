<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function index()
    {
        $wd = \request()->input('wd');
        return view('admin.comment.index',[
            'data' => Comment::with(['article','socialiteUser'])
                            ->when($wd, function($query) use ($wd){
                                return $query->where('content', 'like', "%$wd%");
                            } )
                            ->withTrashed()
                            ->orderBy('comments.created_at','desc')
                            ->paginate(15)

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::withTrashed()->find($id);
        $assign  = compact('comment');

        return view('admin.comment.edit', $assign);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Comment::withTrashed()->find($id)->update($request->except('_token'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Comment $commentModel)
    {
        Comment::destroy($id);

        return redirect()->back();
    }

    /**
     * 恢复删除的评论
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id, Comment $commentModel)
    {
        Comment::onlyTrashed()->find($id)->restore();

        return redirect()->back();
    }

    /**
     * 彻底删除评论
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function forceDelete($id)
    {
        Comment::onlyTrashed()->find($id)->forceDelete();

        return redirect()->back();
    }

    /**
     * 批量替换功能视图
     *
     * @return \Illuminate\View\View
     */
    public function replaceView()
    {
        return view('admin.comment.replaceView');
    }

    /**
     * 批量替换功能
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replace(Request $request, Comment $commentModel)
    {
        $search = $request->input('search');
        $data   = Comment::select('id', 'content')
            ->where('content', 'like', "%$search%")
            ->get();
        foreach ($data as $k => $v) {
            Comment::find($v->id)->update([
                'content' => str_replace($search, $request->input('replace'), $v->content),
            ]);
        }

        return redirect()->back();
    }
}
