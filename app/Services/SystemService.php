<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/29
 * Time: 15:01
 */

namespace App\Services;


use App\Models\Auth\AuthRole;
use Illuminate\Support\Facades\Storage;

class SystemService
{

    /**
     * 返回当前的系统左侧可选菜单集合( tree 结构 )
     *
     * @return array|mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function getMenusTree(){
        $system_menus_conf_found = Storage::disk('system_settings_local')->has('menus.conf.json');

        if ($system_menus_conf_found) {
            return json_decode(Storage::disk('system_settings_local')->get('menus.conf.json') );
        }else{
            return [];
        }
    }

    /**
     * 将管理员提交的系统左侧菜单( tree 结构)保存到文件中
     * 如果存在旧的系统菜单,那么旧的系统菜单会被本次提交的系统菜单覆盖
     *
     * @param array $system_menus (should be a nested array )
     *
     * @return bool
     */
    public static function saveMenusTree(array $system_menus){
        $system_menus = json_encode($system_menus ,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

        return Storage::disk('system_settings_local')->put('menus.conf.json',$system_menus);
    }

    /**
     * 返回系统的所有的 api 的集合
     *
     * Note: laravel 的 routes/api.php 配置文件中每一条 laravel Route 都对应着前端 api/index.js 下的每一条 api ,
     * Note: 前端的 router/routes.js 配置文件中的所有 route 全部对应到 laravel 的 'page.home' 这一条 laravel Route
     *
     * @return array
     */
    public static function getApis()
    {
        $router = app('router');

        $system_apis = collect($router->getRoutes()->getRoutes())
            ->map(function ($route) {
                return [
                    'description'   => empty($route->action['meta'])        ? '' : $route->action['meta']['description'],
                    'middleware'    => empty($route->action['middleware'])  ? '' : $route->action['middleware'],
                    'uri'           => $route->uri,
                ];
            })
            ->filter(function ($api) {
                return ($api['middleware'] === 'app.api' or $api['middleware'] === 'install.api');
            })
            ->map(function($api){
                return [
                    'description'   => $api['description'],
                    'uri'           => $api['uri'],
                ];
            })
            ->values()
            ->toArray();

        return $system_apis;
    }

    /**
     * 返回系统角色集合( tree 结构 )
     * TODO 应该直接用 json 字段去存储,以免每次都要转换
     *
     * @return array|mixed
     */
    public static function getRoles()
    {
        $roles = AuthRole::all();
        $roles->each(function($role){
            $role->menus    = json_decode($role->menus);
            $role->apis     = json_decode($role->apis);
            $role->routes   = json_decode($role->routes);
        });
        return $roles;
    }
}