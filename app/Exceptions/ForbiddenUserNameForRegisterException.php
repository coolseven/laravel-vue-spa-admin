<?php

namespace App\Exceptions;


use App\Http\ResponseCodes;

class ForbiddenUserNameForRegisterException extends \Exception
{

    public function __construct($message = "不允许使用该用户名进行注册")
    {
        parent::__construct($message, ResponseCodes::FORBIDDEN_USERNAME_FOR_REGISTER);
    }
}