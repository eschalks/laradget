<?php

namespace App\Data\Models;

use App\Models\CategoryGroup;
use Inertia\Inertia;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CategoryGroupDto extends Data
{
    public function __construct(
        public readonly int            $id,
        public readonly string         $name,

        /** @var \App\Data\Models\CategoryDto[] */ #[DataCollectionOf(CategoryDto::class)]
        public readonly DataCollection $categories,
    ) {
    }

    /**
     * @return DataCollection<int, \App\Data\Models\CategoryGroupDto>
     */
    public static function fetchAll(): DataCollection
    {
        return CategoryGroupDto::collection(CategoryGroup::with('categories')
                                                         ->orderBy('seq')
                                                         ->get());
    }

    public static function shareWithInertia(): void
    {
        Inertia::share([
                           'categoryGroups' => static::fetchAll(...),
                       ]);
    }
}
