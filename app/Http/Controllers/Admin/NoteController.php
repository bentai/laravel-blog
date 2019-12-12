<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use App\Http\Requests\Note\Store;
class NoteController extends Controller
{
    //
    public function index(Note $noteModel)
    {
        $wd = \request()->input('wd');
        $data = $noteModel
            ->orderBy('created_at', 'desc')
            ->withTrashed()
            ->when($wd, function ($query) use ($wd){
                return $query->where('content', 'like', "%$wd%");
            })
            ->paginate(50);
        $assign = compact('data');

        return view('admin.note.index', $assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.note.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        Note::create($request->only('content'));

        return redirect('admin/note/index');
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
        $data   = Note::withTrashed()->find($id);
        $assign = compact('data');

        return view('admin.note.edit', $assign);
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
        Note::withTrashed()->find($id)->update($request->except('_token'));

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
        Note::destroy($id);

        return redirect('admin/note/index');
    }

    /**
     * 恢复删除的随言碎语
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function restore($id)
    {
        Note::onlyTrashed()->find($id)->restore();

        return redirect('admin/note/index');
    }

    /**
     * 彻底删除随言碎语
     *
     * @param      $id
     * @param Note $noteModel
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function forceDelete($id)
    {
        Note::onlyTrashed()->find($id)->forceDelete();

        return redirect('admin/note/index');
    }
}
