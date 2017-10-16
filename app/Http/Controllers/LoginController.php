<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/8/29
 * Time: 14:53
 */

namespace App\Http\Controllers;


use App\Exceptions\CaptchaMismatchException;
use App\Exceptions\UsernameOrPasswordMismatchException;
use App\Services\AccountService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws CaptchaMismatchException
     * @throws UsernameOrPasswordMismatchException
     */
    public function login(Request $request){

        $this->validate($request, [
            'username' => 'required', 'password' => 'required', 'captcha'  => 'required'
        ]);

        if(!captcha_check($request->input('captcha'))){
            throw new CaptchaMisMatchException();
        }

        AccountService::login( $request->get('username') , $request->get('password') );

        return success('登录成功',[
            'login_success' => true,
        ]);
    }

    public function logout()
    {
        AccountService::logout();

        return success('退出成功',[
            'session_cleared'   => true,
        ]);
    }

}