<?php

namespace App\Data\Forms;

use App\Models\Category;
use App\Rules\Attributes\ModelExists;
use App\Rules\ModelExistsRule;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class UpdateTransactionForm extends Data
{
    public function __construct(
        #[Rule(new ModelExistsRule(Category::class))]
        #[MapOutputName('category_id')]
        public readonly int $categoryId,
        public readonly bool $updateCounterParty=false,
    )
    {

    }
}
