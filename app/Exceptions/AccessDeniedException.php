<?php

namespace App\Exceptions;


use App\Http\ResponseCodes;

class AccessDeniedException extends \Exception
{

    public function __construct($message = "您无权限进行该操作")
    {
        parent::__construct($message, ResponseCodes::ACCESS_DENIED);
    }
}