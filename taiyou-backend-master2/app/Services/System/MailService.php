<?php

namespace App\Services\System;

use App\Exceptions\CustomGenericException;
use App\Mail\system\TestMail;
use App\MailTest;
use App\Services\Service;
use Illuminate\Support\Facades\Mail;

class MailService extends Service
{
    public function __construct(MailTest $mailTest)
    {
        parent::__construct($mailTest);
    }

    public function sendMail($request){
        
        return Mail::to($request->toemail)->send(new TestMail($request->all()));
    }
}
