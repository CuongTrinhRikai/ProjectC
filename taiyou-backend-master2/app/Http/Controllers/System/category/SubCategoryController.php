<?php

namespace App\Http\Controllers\System\category;

use App\Http\Controllers\System\ResourceController;
use App\Services\System\SubCategoryService;

class SubCategoryController extends ResourceController
{
    public function __construct(SubCategoryService $subCategoryService){
        parent::__construct($subCategoryService);
    }

    public function isSubModule()
    {
        return true;
    }

    public function moduleName()
    {
        return 'categories';
    }

    public function subModuleName()
    {
        return 'sub-category';
    }

    public function viewFolder()
    {
        return 'system.category';
    }
}
