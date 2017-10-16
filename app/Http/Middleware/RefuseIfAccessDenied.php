<?php


namespace App\Http\Middleware;

use App\Exceptions\AccessDeniedException;
use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RefuseIfAccessDenied
{
    public function handle(Request $request, Closure $next){
        $except_api_uris    = ['api/user/login','api/user/logout','api/session/sync'];

        // $current_api_uri 形如: 'api/user/delete'
        $current_api_uri   = Route::getCurrentRoute()->uri();

        // 在白名单中时，不做检查
        if (in_array($current_api_uri, $except_api_uris)) {
            return $next($request);
        }

        // 否则检查当前用户是否具备该 api 的访问权限
        $current_user_has_api = AuthService::currentUserHasApi($current_api_uri);
        if (!$current_user_has_api) {
            // TODO  insert a failed attempt record to database before throwing exception
            throw new AccessDeniedException('您没有权限进行该操作 ( 接口地址：' . $current_api_uri . ' )');
        }

        return $next($request);
    }
}