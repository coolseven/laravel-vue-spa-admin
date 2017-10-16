<?php
/**
 * Created for laravel-spa-admin.
 * File: UserController.php
 * User: cools
 * Date: 2017/8/31 0031
 * Time: 0:40
 * Description :
 */

namespace App\Http\Controllers;


use App\Services\AccountService;
use App\Services\SystemService;

/**
 * Class SyncController
 *
 * @package App\Http\Controllers
 */
class SyncController extends Controller
{
    /**
     * 返回当前用户所需的最新数据,主要包括用户信息和系统最新的设置
     * 该方法会在以下情况下调用:
     * 1. 用户刷新了浏览器,此时浏览器端的 vuex 需要重新初始化
     * 2. 管理员修改了系统设置,如系统左侧菜单配置,角色集合等
     * 3. 管理员修改了用户的信息,如用户的名称,用户所属的角色等
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function sync()
    {
        // 获取当前用户的综合信息
        $user            = AccountService::getCurrentUser();

        // 获取系统的角色列表
        $system_roles    = SystemService::getRoles();

        // 获取系统的左侧菜单树设置
        $system_menus    = SystemService::getMenusTree();

        // 获取系统的 api 列表
        $system_apis     = SystemService::getApis();

        return success(
            '请求成功',
            [
                'user' => $user,
                'system' => [
                    'roles' => $system_roles,
                    'menus' => $system_menus,
                    'apis'  => $system_apis,
                ]
            ]
        );
    }
}