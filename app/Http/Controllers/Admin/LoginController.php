<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialiteUser;
use Auth;

class LoginController extends Controller
{
    /**
     * 登录页面
     *
     * @return mixed
     */
    public function index()
    {

        return view('admin.login.index');
    }

    /**
     * 退出登录
     *
     * @return mixed
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('socialite')->logout();

        return redirect('admin/login/index');
    }
}
