<?php

namespace App\Exceptions;


use App\Http\ResponseCodes;

class ResourceOutdatedException extends \Exception
{

    public function __construct($message = "资源有修改，请重新刷新页面")
    {
        parent::__construct($message, ResponseCodes::RESOURCE_OUTDATED);
    }
}