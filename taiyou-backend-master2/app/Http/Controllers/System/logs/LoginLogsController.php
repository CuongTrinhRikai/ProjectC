<?php

namespace App\Http\Controllers\System\logs;

use App\Http\Controllers\System\ResourceController;
use App\Services\System\LoginLogService;

class LoginLogsController extends ResourceController
{
    public function __construct(LoginLogService $loginService){
        parent::__construct($loginService);
    }

    public function moduleName()
    {
        return 'login-logs';
    }

    public function viewFolder()
    {
        return 'system.loginLogs';
    }
}
