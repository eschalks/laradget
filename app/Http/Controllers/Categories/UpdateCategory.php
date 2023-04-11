<?php

namespace App\Http\Controllers\Categories;

use App\Data\Forms\UpdateCategoryForm;
use App\Data\Models\CategoryGroupDto;
use App\Http\Controllers\Controller;
use App\Models\Category;

class UpdateCategory extends Controller
{
    public function __invoke(Category $category, UpdateCategoryForm $form)
    {
        \DB::transaction(function() use ($category, $form) {
            $category->update($form->all());
        });

        CategoryGroupDto::shareWithInertia();
    }
}
