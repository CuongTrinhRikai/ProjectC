<?php

namespace App\Exceptions;

use Exception;

class CustomGenericException extends Exception
{
    public $message = '';
    public $alert = '';
    public function __construct($message = 'Something went wrong', $alert='alert-danger')
    {
       \Request::flash();
        $this->message = $message;
        $this->alert = $alert;

    }
}
