<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Baijunyao\LaravelUpload\Upload;
use Illuminate\Http\Request;
use App\Models\Config;
use Artisan;
class ConfigController extends Controller
{

    public function email()
    {
        return view('admin.config.email');
    }


    public function commentAudit()
    {
        return view('admin.config.commentAudit');
    }

    /**
     * 备份
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function backup()
    {

        return view('admin.config.backup');
    }

    public function seo()
    {
        return view('admin.config.seo');
    }

    /**
     * QQ群设置
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function qqQun()
    {
        return view('admin.config.qqQun');
    }

    /**
     * 社会化分享
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function socialShare()
    {
        return view('admin.config.qqQun');
    }

    /**
     * 编辑其他设置
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('admin.config.edit');
    }

    /**
     * 社会化分享
     *
     * @throws \Exception
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clear()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        return redirect()->back();
    }


    public function update(Request $request, Config $configModel)
    {
        $configs = $request->except('_token');
        //判断是否上传图片
        if ($request->hasFile('153'))
        {
            $result = Upload::file('153','uploads/images', [], false);
            $configs[153] = $request['status_code'] == 200 ? $request['data']['path'] : '';
        }
        //
        if (isset($configs['165']) && empty($configs['164'])) {
            $configs['164'] = [];
        }

        foreach ($configs as $id => $config)
        {
            Config::find($id)->update([
                'value' => is_array($config) ? json_encode($config) : $config,
            ]);
        }
        return redirect()->back();

    }
}
