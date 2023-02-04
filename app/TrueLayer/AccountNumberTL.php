<?php

namespace App\TrueLayer;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AccountNumberTL extends Data
{
    public function __construct(
        public readonly string $iban,
    ) {
    }
}
