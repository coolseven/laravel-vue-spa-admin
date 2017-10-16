<?php
/**
 * Created for laravel-spa-admin.
 * File: ApiNotFoundException.php
 * User: cools
 * Date: 2017/9/3 0003
 * Time: 9:04
 * Description :
 */

namespace app\Exceptions;


use App\Http\ResponseCodes;

class ApiDeprecatedException extends \Exception
{
    public function __construct($message = "该接口已废弃" )
    {
        parent::__construct($message,$code = ResponseCodes::API_DEPRECATED);
    }
}