<?php
/**
 * Created for laravel-spa-admin.
 * File: ApiNotFoundException.php
 * User: cools
 * Date: 2017/9/3 0003
 * Time: 9:04
 * Description :
 */

namespace App\Exceptions;


use App\Http\ResponseCodes;

class AppNotInstalledException extends \Exception
{
    public function __construct($message = "系统正在维护中,请稍后再访问" )
    {
        parent::__construct($message,$code = ResponseCodes::APP_NOT_INSTALLED);
    }
}