<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\Store;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    //

    //添加保存
    public function store(Store $request)
    {
        Debugbar();
        $tag = Tag::create($request->only('name', 'keywords', 'description'));
        if ($request->ajax()){
            return response()->json($tag);
        }
    }
}
