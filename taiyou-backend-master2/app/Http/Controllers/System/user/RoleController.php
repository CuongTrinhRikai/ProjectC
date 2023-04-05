<?php

namespace App\Http\Controllers\System\user;

use App\Http\Controllers\System\ResourceController;
use App\Services\System\RoleService;

class RoleController extends ResourceController
{
    public function __construct(RoleService $roleService)
    {
        parent::__construct($roleService);
    }

    public function storeValidationRequest()
    {
        return 'App\Http\Requests\system\roleRequest';
    }
    
    public function moduleName()
    {
        return 'roles';
    }

    public function viewFolder()
    {
        return 'system.role';
    }
}
