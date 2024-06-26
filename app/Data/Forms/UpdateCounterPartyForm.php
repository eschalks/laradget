<?php

namespace App\Data\Forms;

use App\Models\Category;
use App\Rules\Attributes\ModelExists;
use App\Rules\ModelExistsRule;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class UpdateCounterPartyForm extends Data
{
    public function __construct(
        #[Rule(new ModelExistsRule(Category::class))]
        public readonly int $categoryId,
    )
    {
    }
}
