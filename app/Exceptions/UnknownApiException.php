<?php


namespace App\Exceptions;


use App\Http\ResponseCodes;

/**
 * 未知的接口错误
 *
 * Class AppException
 * @package App\Exceptions
 */
class UnknownApiException extends \Exception
{
    public function __construct($message = "接口未知错误,请联系管理员" )
    {
        parent::__construct($message ,ResponseCodes::UNKNOWN_API_ERROR);
    }
}