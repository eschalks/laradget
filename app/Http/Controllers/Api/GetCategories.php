<?php

namespace App\Http\Controllers\Api;

use App\Data\Models\CategoryGroupDto;
use App\Http\Controllers\Controller;

class GetCategories extends Controller
{
    public function __invoke()
    {
        return CategoryGroupDto::fetchAll();
    }
}
