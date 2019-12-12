<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data   = User::withTrashed()->get();
        $assign = compact('data');

        return view('admin.user.index', $assign);
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
        $data   = User::withTrashed()->find($id);
        $assign = compact('data');

        return view('admin.user.edit', $assign);
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
        User::withTrashed()->find($id)->update($request->except('_token'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('admin/user/index');
    }

    /**
     * 恢复删除的标签
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id)
    {
        User::onlyTrashed()->find($id)->restore();

        return redirect('admin/user/index');
    }

    /**
     * 彻底删除标签
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function forceDelete($id)
    {
        User::onlyTrashed()->find($id)->forceDelete();

        return redirect('admin/user/index');
    }
}
