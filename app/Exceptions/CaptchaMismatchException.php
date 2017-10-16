<?php

namespace App\Exceptions;


use App\Http\ResponseCodes;

class CaptchaMismatchException extends \Exception
{

    public function __construct($message = "验证码错误")
    {
        parent::__construct($message,$code = ResponseCodes::CAPTCHA_MISMATCH);
    }

}