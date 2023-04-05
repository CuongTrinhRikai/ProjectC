<?php
namespace App\Transformers;

use App\Model\Category;
use League\Fractal\TransformerAbstract;

class CategoriesTransformer extends TransformerAbstract
{
  public function transform(Category $category)
  {
    return [
      'id' => $category->id,
      'categoryName' => $category->name,
      'categoryAttribute' => $category->attributes,
      'description' => $category->dexcription,
      'status' => $category->status,
      'subCategory' => $category->child()->get() ?? null
    ];
  }
}