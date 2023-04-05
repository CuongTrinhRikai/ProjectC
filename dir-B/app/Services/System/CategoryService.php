<?php

namespace App\Services\System;

use App\Model\Category;
use App\Services\Service;

class CategoryService extends Service
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }
    // public function indexPageData($request)
    // {
    //     return [
    //         'items' => $this->model->where('parent_id', null)->paginate(20)
    //     ];
    // }

    
    // public function singleData($id)
    // {
    //     return $this->itemByIdentifier($id);
    // }
}
