<?php


namespace App\Http\Middleware;

use App\Exceptions\AuthenticationFailedException;
use App\Services\AccountService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RefuseIfAuthenticationFailed
{
    /**
     * 如果用户未登录,则终止后续的处理
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     * @throws \App\Exceptions\AuthenticationFailedException
     */
    public function handle(Request $request, Closure $next){
        $except_route_names = ['api.user.login','api.user.logout'];

        $current_route_name   = Route::currentRouteName();

        // 在白名单中时，不做检查
        if (in_array($current_route_name, $except_route_names)) {
            return $next($request);
        }

        // 否则检查用户是否已登陆
        $user_has_logged_in = AccountService::userHasLoggedIn();
        if(!$user_has_logged_in){
            throw new AuthenticationFailedException();
        }

        return $next($request);
    }
}