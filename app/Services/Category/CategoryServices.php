<?php


namespace App\Services\Category;


use App\Models\Category;

class CategoryServices
{
    /**
     * @var Category
     */
    private $category;

    public function __construct(Category $category)
    {

        $this->category = $category;
    }


}
