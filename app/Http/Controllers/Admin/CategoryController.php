<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\Category\Store;
class CategoryController extends Controller
{
    //
    public function index(Category $categoryModel)
    {
        return view('admin.category.index',[
            'categoty' => $categoryModel->withTrashed()->orderBy('sort')->get()
        ]);
    }

    /**
     *
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * @param Store $request
     * @param Category $categoryModel
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     */
    public function store(Store $request, Category $categoryModel)
    {
        $categoryModel->create($request->except('_token'));
        return redirect('admin/category/index');
    }

    /**
     * @param Category $categoryModel
     * @param $id
     *
     */
    public function edit(Category $categoryModel, $id)
    {
        return  view('admin.category.edit',[
            'data' => $categoryModel->withTrashed()->find($id)
        ]);

    }

    /**
     * @param Request $request
     * @param Category $categoryModel
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, Category $categoryModel, $id)
    {
        $categoryModel->withTrashed()->find($id)->update($request->except('_token'));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param Category $categoryModle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sort(Request $request, Category $categoryModle)
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
        $categoryModle->updateBatch($sortData);
        return redirect()->back();
    }

    /**
     * @param Category $categoryModle
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $categoryModle, $id)
    {
        $categoryModle->destroy($id);
        return redirect()->back();
    }

    /**
     * @param Category $categoryModle
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Category $categoryModle, $id)
    {
        $categoryModle->onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        Category::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }
}
