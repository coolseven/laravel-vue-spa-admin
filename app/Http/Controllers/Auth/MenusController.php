<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/1
 * Time: 16:16
 */

namespace app\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Services\SystemService;


class MenusController extends Controller
{
    /**
     * 更新系统的左侧菜单集合
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function save()
    {
        $system_menus = request()->get('menus');

        SystemService::saveMenusTree($system_menus);

        return success('已保存', [
           'saved'  => true,
        ]);

    }

    /**
     * 返回系统左侧菜单集合( tree 结构 )
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function all()
    {
        $system_menus = SystemService::getMenusTree();

        return success('请求成功', $system_menus);
    }
}