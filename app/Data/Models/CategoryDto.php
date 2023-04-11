<?php

namespace App\Data\Models;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CategoryDto extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        #[MapInputName('is_debit')]
        public readonly bool $isDebit,
        #[MapInputName('month_offset')]
        public readonly int $monthOffset,
    ) {

    }
}
