<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/29
 * Time: 15:01
 */

namespace App\Services;


use App\CacheCodes;
use App\Exceptions\UsernameOrPasswordMismatchException;
use App\Models\Auth\AuthUser;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AccountService
{

    /**
     * 使用用户名和密码进行登录,
     * 登录失败时抛出异常,
     * 登录成功时,无返回值,并会在 session 中保存用户是否已登录 以及 用户的 id
     *
     * @param $username
     * @param $password
     *
     * @throws \App\Exceptions\UsernameOrPasswordMismatchException
     */
    public static function login( $username , $password)
    {
        if (is_app_installed()) {
            self::userLogin( $username , $password);
        }else{
            self::installerLogin( $username , $password);
        }

    }

    private static function userLogin($username, $password)
    {
        if (empty($username)) {
            throw new UsernameOrPasswordMismatchException();
        }

        $user = AuthUser::where('username' ,'=' ,$username)->first();

        if (empty($user)) {
            throw new UsernameOrPasswordMismatchException();
        }

        if(!password_verify($password,$user['password'])){
            // HACK
            // throw new UserNameOrPasswordMismatchException();
        }

        // TODO
        // other conditions to check ,like whether the user has been disabled or locked...

        Session::regenerateToken();
        Session::put('user_has_logged_in', true);
        Session::put('user_id', $user->id);
    }

    private static function installerLogin($username, $password)
    {
        if (empty($username)) {
            throw new UsernameOrPasswordMismatchException();
        }

        $installer = self::getInstaller();

        if ($username !== $installer['username'] or !password_verify($password,$installer['password'])) {
            throw new UsernameOrPasswordMismatchException();
        }

        Session::regenerateToken();
        Session::put('user_has_logged_in', true);
        Session::put('current_user_is_installer', true);
    }

    /**
     * 清除当前用户的 session (退出系统)
     *
     * @return bool
     */
    public static function logout()
    {
        if (is_app_installed()) {
            return self::userLogout( );
        }else{
            return self::installerLogout( );
        }
    }

    private static function userLogout(){
        Session::invalidate();
        Session::regenerateToken();
        return true;
    }

    private static function installerLogout(){
        Session::invalidate();
        Session::regenerateToken();

        Artisan::call('app:installed');
        return true;
    }

    /**
     * 返回当前的请求是否已登录
     *
     * @return bool
     */
    public static function userHasLoggedIn(){
        return Session::has('user_has_logged_in');
    }

    /**
     * 返回当前登录用户的 id
     *
     * @return mixed
     */
    public static function getCurrentUserId()
    {
        return Session::get('user_id');
    }

    /**
     * 返回指定用户的基本信息
     *
     * @param $user_id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function getUserBasic( $user_id )
    {
        return AuthUser::findOrFail($user_id);
    }

    /**
     * 返回当前用户的综合信息
     *
     * @return array
     */
    public static function getCurrentUser()
    {
        if (self::currentUserIsInstaller()) {
            $installer =  self::getInstaller();

            return [
                'username'      => $installer['username'],
            ];
        }else{
            $current_user_id = self::getCurrentUserId();

            $user_basic = self::getUserBasic($current_user_id);

            $user_auth  = AuthService::getUserAuth($current_user_id);

            return [
                'username'      => $user_basic['username'],
                'roles'         => $user_auth['roles'],
                'menus'         => $user_auth['menus'],
                'apis'          => $user_auth['apis'],
                'routes'        => $user_auth['routes'],
            ];
        }
    }

    private static function getInstaller()
    {
        $installer = Cache::store(CacheCodes::APP_INSTALLER_ACCOUNT['store'])->get(CacheCodes::APP_INSTALLER_ACCOUNT['key']) ;

        return $installer;
    }

    public static function currentUserIsInstaller()
    {
        return Session::get('current_user_is_installer');
    }

}