<?php

namespace App\Http\Controllers\System;

use App\Exceptions\CustomGenericException;
use App\Http\Requests\system\testMailRequest;
use App\Services\System\MailService;

class MailTestController extends ResourceController
{
    public function __construct(MailService $mailService)
    {
        parent::__construct($mailService);
    }
    public function moduleName()
    {
        return 'mail-test';
    }
    public function viewFolder()
    {
        return 'system.mailtest';
    }

    public function sendEmail(testMailRequest $request)
    {
        try {
            $this->service->sendMail($request);
            return redirect()->back()->withErrors(['success' => 'Mail Sent successfully .']);
        } catch (\Exception $e) {
            throw new CustomGenericException($e->getMessage());
        }
    }
}
