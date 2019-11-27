<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
class IndexController extends Controller
{

    public function index()
    {
        dd( url('admin/login/index'));
//        dd(Route::current());
    }
}
