<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/29
 * Time: 13:46
 */

namespace App\Http\Controllers;


use App\Exceptions\ApiNotFoundException;

class AppController extends Controller
{
    /**
     *
     * 对于非 json 的请求,统一返回我们 SPA 应用的 html 模板
     * 对于 json 的请求,统一返回 接口不存在的 json 响应
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\ApiNotFoundException
     */
    public function index()
    {
        if (request()->expectsJson()) {
            throw new ApiNotFoundException();
        }

        if (is_app_installed()) {
            return view('app');
        }else{
            return view('install');
        }
    }

}