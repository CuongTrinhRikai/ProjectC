<?php

namespace App\Http\Controllers\System\profile;

use App\Http\Controllers\System\ResourceController;
use App\Services\System\ProfileService;

class ProfileController extends ResourceController
{
    public function __construct(ProfileService $profileService)
    {
        parent::__construct($profileService);
    }

    public function storeValidationRequest(){
        return  'App\Http\Requests\system\profileRequest';
    }
    
    public function moduleName()
    {
        return 'profile';
    }
    public function viewFolder()
    {
        return 'system.profile';
    }
}
