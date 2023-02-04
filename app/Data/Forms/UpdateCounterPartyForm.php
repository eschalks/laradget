<?php

namespace App\Data\Forms;

use App\Models\Category;
use App\Rules\Attributes\ModelExists;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;

class UpdateCounterPartyForm extends Data
{
    public function __construct(
        #[ModelExists(Category::class)]
        #[MapInputName('category_id')]
        #[MapOutputName('default_category_id')]
        public readonly int $defaultCategoryId
    )
    {
    }
}
