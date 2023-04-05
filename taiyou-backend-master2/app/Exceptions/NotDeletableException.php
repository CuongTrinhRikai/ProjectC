<?php

namespace App\Exceptions;

use Exception;

class NotDeletableException extends Exception
{
    public $message = '';
    public function __construct($message = 'This Record is not deletable.')
    {
        $this->message = $message;
    }
}
