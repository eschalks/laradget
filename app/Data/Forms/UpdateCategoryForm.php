<?php

namespace App\Data\Forms;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateCategoryForm extends Data
{
    public function __construct(
        #[MapOutputName('is_debit')]
        public bool|Optional $isDebit,
        #[MapOutputName('month_offset')]
        public int|Optional $monthOffset,
    )
    {
    }
}
