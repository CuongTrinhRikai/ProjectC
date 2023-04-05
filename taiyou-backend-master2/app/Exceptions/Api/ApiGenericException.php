<?php

namespace App\Exceptions\Api;

use Exception;

class ApiGenericException extends Exception
{
    public $message = '';
    public $statusCode = '';
    public function __construct($message = 'Something went wrong', $statusCode = 401)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
    }
}
