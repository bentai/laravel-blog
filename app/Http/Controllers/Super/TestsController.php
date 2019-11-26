<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    //
    public function index()
    {
        return 111;
    }

    public function show($id)
    {
        return '请求参数为：'.$id;
    }

    public function store()
    {
        return ' 测试';
    }
}
