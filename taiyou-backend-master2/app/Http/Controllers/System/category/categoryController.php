<?php

namespace App\Http\Controllers\System\category;

use App\Http\Controllers\System\ResourceController;
use App\Services\System\CategoryService;

class categoryController extends ResourceController
{
    public function __construct(CategoryService $categoryService)
    {
        parent::__construct($categoryService);
    }

    public function storeValidationRequest()
    {
        return 'App\Http\Requests\system\categoryRequest';
    }

    public function updateValidationRequest()
    {
        return 'App\Http\Requests\system\categoryRequest';
    }

    public function moduleName()
    {
        return 'categories';
    }

    public function viewFolder()
    {
        return 'system.category';
    }
}
