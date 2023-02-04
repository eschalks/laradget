<?php

namespace App\Data\Forms;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class ImportAccountForm extends Data
{
    public function __construct(
        #[ArrayType]
        #[Required]
        public readonly array $accounts,
    )
    {

    }
}
