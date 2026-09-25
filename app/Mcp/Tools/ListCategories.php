<?php

namespace App\Mcp\Tools;

use App\Models\CategoryGroup;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Description('List available transaction categories and groups. Use category IDs when categorizing transactions.')]
#[IsReadOnly]
class ListCategories extends Tool
{
    public function handle(Request $request): ResponseFactory
    {
        $groups = CategoryGroup::query()->with('categories')->orderBy('seq')->get()
            ->map(fn (CategoryGroup $group) => [
                'id' => $group->id,
                'name' => $group->name,
                'categories' => $group->categories->map(fn ($category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'is_debit' => (bool) $category->is_debit,
                    'month_offset' => $category->month_offset,
                ])->all(),
            ])->all();

        return Response::structured(['groups' => $groups]);
    }
}
