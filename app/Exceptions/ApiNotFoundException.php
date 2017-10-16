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

class ApiNotFoundException extends \Exception
{
    public function __construct($message = "接口不存在或地址不正确" )
    {
        parent::__construct($message,$code = ResponseCodes::API_NOT_FOUND);
    }
}