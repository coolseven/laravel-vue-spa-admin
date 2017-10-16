<?php

namespace App\Exceptions;


use App\Http\ResponseCodes;

class UsernameOrPasswordMismatchException extends \Exception
{

    public function __construct($message = "用户名或密码不正确")
    {
        parent::__construct($message, ResponseCodes::USERNAME_OR_PASSWORD_MISMATCH);
    }
}