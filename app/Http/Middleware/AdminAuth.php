<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 如果不是管理员或者没有登录;则重定向到登录页面
        if (!Auth::guard('admin')->check()) {
            return redirect('admin/login/index');
        }
//        dump($request);
        return $next($request);
    }
}
