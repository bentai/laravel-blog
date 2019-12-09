<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\Store;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index(Tag $TagModel)
    {
        return view('admin.tag.index',[
            'tag' => $TagModel->withTrashed()->get()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * @param Store $request
     * @param Tag $TagModel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Store $request, Tag $TagModel)
    {
        $tag = Tag::create($request->only('name', 'keywords', 'description'));
        if ($request->ajax()){
            return response()->json($tag);
        }
        return redirect('admin/tag/index');
    }

    /**
     * @param Tag $TagModel
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Tag $TagModel, $id)
    {
        return  view('admin.tag.edit',[
            'data' => $TagModel->withTrashed()->find($id)
        ]);

    }

    /**
     * @param Request $request
     * @param Tag $TagModel
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Tag $TagModel, $id)
    {
        $TagModel->withTrashed()->find($id)->update($request->except('_token'));
//        return redirect()->back();
        return redirect('admin/tag/index');

    }

    /**
     * @param Request $request
     * @param Tag $TagModle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sort(Request $request, Tag $TagModle)
    {
        $data = $request->except('_token');
        $sortData = [];
        foreach ($data as $k => $v)
        {
            $sortData[] = [
                'id'   => $k,
                'sort' => $v
            ];
        }
        $TagModle->updateBatch($sortData);
        return redirect()->back();
    }

    /**
     * @param Tag $TagModle
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tag $TagModle, $id)
    {
        $TagModle->destroy($id);
        return redirect()->back();
    }

    /**
     * @param Tag $TagModle
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Tag $TagModle, $id)
    {
        $TagModle->onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        Tag::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }
}
