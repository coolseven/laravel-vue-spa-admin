<?php


namespace App\Exceptions;


use App\Http\ResponseCodes;

class DataNotFoundException extends \Exception
{

    public function __construct($message = "未找到相关记录")
    {
        parent::__construct($message, ResponseCodes::DATA_NOT_FOUND);
    }
}