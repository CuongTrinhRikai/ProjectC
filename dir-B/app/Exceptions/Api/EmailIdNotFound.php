<?php

namespace App\Exceptions\Api;

use Exception;

class EmailIdNotFound extends Exception
{
    public $message = '';
    public function __construct($message = 'Email-id is not present.')
    {
        $this->message = $message;
    }
}
