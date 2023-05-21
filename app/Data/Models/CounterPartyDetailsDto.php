<?php

namespace App\Data\Models;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

class CounterPartyDetailsDto extends Data
{
    public function __construct(
        public readonly int     $id,
        public readonly string  $name,
        public readonly ?string $iban,
        #[MapInputName("default_category_id")]
        public readonly ?int    $defaultCategoryId,
    ) {
    }
}
