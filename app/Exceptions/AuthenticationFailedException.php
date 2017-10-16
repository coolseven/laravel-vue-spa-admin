<?php


namespace App\Exceptions;


use App\Http\ResponseCodes;

class AuthenticationFailedException extends \Exception
{
    public function __construct($message = "您未登录或会话已过期")
    {
        parent::__construct($message, ResponseCodes::NOT_AUTHENTICATED);
    }
}