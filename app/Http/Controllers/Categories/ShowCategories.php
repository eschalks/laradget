<?php

namespace App\Http\Controllers\Categories;

use App\Data\Models\CategoryGroupDto;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ShowCategories extends Controller
{
    public function __invoke()
    {
        CategoryGroupDto::shareWithInertia();
        return Inertia::render('CategoriesPage');
    }
}
