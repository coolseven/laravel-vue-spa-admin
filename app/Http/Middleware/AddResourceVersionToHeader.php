<?php


namespace App\Http\Middleware;

use App\Exceptions\ResourceOutdatedException;
use Closure;
use Illuminate\Http\Request;

class AddResourceVersionToHeader
{
    /**
     * 在响应头中添加当前资源版本号
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     * @throws ResourceOutdatedException
     */
    public function handle(Request $request, Closure $next){
        $response = $next($request);

        // TODO
        $resourceFingerPrint = 'todo';

        $headers = [
            'X-Resource-FingerPrint' => $resourceFingerPrint,
        ];

        $response->headers->add($headers);
        return $response;
    }
}