<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nav;
use App\Http\Requests\Nav\Store;
class NavController extends Controller
{
    //
    public function index(Nav $NavModel)
    {
        return view('admin.nav.index',[
            'nav' => $NavModel->withTrashed()->orderBy('sort')->get()
        ]);
    }

    /**
     *
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.nav.create');
    }

    /**
     * @param Store $request
     * @param Nav $NavModel
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     */
    public function store(Store $request, Nav $NavModel)
    {
        $NavModel->create($request->except('_token'));
        return redirect('admin/nav/index');
    }

    /**
     * @param Nav $NavModel
     * @param $id
     *
     */
    public function edit(Nav $NavModel, $id)
    {
        return  view('admin.nav.edit',[
            'nav' => $NavModel->withTrashed()->find($id)
        ]);

    }

    /**
     * @param Request $request
     * @param Nav $NavModel
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, Nav $NavModel, $id)
    {
        $NavModel->withTrashed()->find($id)->update($request->except('_token'));
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param Nav $NavModle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sort(Request $request, Nav $NavModle)
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
        $NavModle->updateBatch($sortData);
        return redirect()->back();
    }

    /**
     * @param Nav $NavModle
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Nav $NavModle, $id)
    {
        $NavModle->destroy($id);
        return redirect()->back();
    }

    /**
     * @param Nav $NavModle
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Nav $NavModle, $id)
    {
        $NavModle->onlyTrashed()->find($id)->restore();
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        Nav::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back();
    }
}
