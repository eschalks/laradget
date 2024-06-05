<?php

namespace App\Data\Models;

use App\Models\CategoryGroup;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

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
     * @return Collection<int, CategoryGroupDto>
     */
    public static function fetchAll(): Collection
    {
        return CategoryGroupDto::collect(CategoryGroup::with('categories')
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
