<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/29
 * Time: 15:01
 */

namespace App\Services;


use App\Models\Auth\AuthUser;

class AuthService
{
    /**
     * 返回指定用户是否具备某个接口的访问权限
     *
     * @param int    $user_id 用户 id
     * @param string $api_uri 接口的地址,形如 'api/auth/role/delete'
     *
     * @return bool
     */
    public static function userHasApi(int $user_id, string $api_uri)
    {
        $user_apis = self::getUserApis($user_id);

        return $user_apis->contains('uri','=',$api_uri);
    }

    /**
     * 返回当前用户是否具备某个接口的访问权限
     *
     * @param string $api_uri
     *
     * @return bool
     */
    public static function currentUserHasApi(string $api_uri){
        $current_user_id = AccountService::getCurrentUserId();

        return self::userHasApi($current_user_id , $api_uri);
    }

    /**
     * 返回指定用户的角色集合
     *
     * @param $user_id
     *
     * @return mixed
     */
    public static function getUserRoles( $user_id )
    {
        $user = AuthUser::with('roles')->findOrFail($user_id);

        return $user->roles->each(function($role){
            $role->menus    = json_decode($role->menus,1);
            $role->apis     = json_decode($role->apis,1);
            $role->routes   = json_decode($role->routes,1);
        });
    }

    /**
     * 返回指定用户的 api 集合(结构为一维的 Collection )
     * (用户如果属于多个角色,那么返回的结果是这些角色的 api 的并集,且已去重)
     *
     * @param int $user_id
     *
     * @return \Illuminate\Support\Collection
     */
    private static function getUserApis(int $user_id )
    {
        $user = AuthUser::with('roles')->findOrFail($user_id);

        $user_apis = [];
        foreach ($user->roles as $user_role){
            $user_apis += json_decode($user_role->apis);
        }

        return collect($user_apis)->unique();
    }

    /**
     * 返回指定用户 id 的权限信息
     *
     * @param $user_id
     *
     * @return array
     */
    public static function getUserAuth( $user_id )
    {
        $user_roles = self::getUserRoles($user_id);

        $user_menus     = [];
        $user_apis      = [];
        $user_routes    = [];

        foreach ($user_roles as $user_role) {
            $user_menus     += $user_role->menus;
            $user_apis      += $user_role->apis;
            $user_routes    += $user_role->routes;
        }

        return [
            'roles'     => $user_roles,
            'menus'     => $user_menus,
            'apis'      => $user_apis,
            'routes'    => $user_routes,
        ];
    }


}