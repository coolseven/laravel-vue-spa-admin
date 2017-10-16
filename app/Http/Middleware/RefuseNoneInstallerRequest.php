<?php


namespace App\Http\Middleware;

use App\Exceptions\AppNotInstalledException;
use App\Services\AccountService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RefuseNoneInstallerRequest
{
    /**
     * 如果系统处于安装中的状态,那么拒绝游客和普通用户的访问,只有安装账户才能继续访问
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     * @throws \App\Exceptions\AppNotInstalledException
     * @throws \App\Exceptions\AuthenticationFailedException
     */
    public function handle(Request $request, Closure $next){
        $except_route_names = ['api.user.login','api.user.logout'];

        $current_route_name   = Route::currentRouteName();

        // 在白名单中时，不做检查
        if (in_array($current_route_name, $except_route_names)) {
            return $next($request);
        }

        // 如果用户已登录,则检查当前用户是否是 installer 账户
        $current_user_is_installer = AccountService::currentUserIsInstaller();
        if (!$current_user_is_installer) {
            throw new AppNotInstalledException();
        }

        return $next($request);
    }
}