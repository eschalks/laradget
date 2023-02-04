<?php

namespace App\TrueLayer;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AccountTL extends Data
{
    public function __construct(
        public readonly string $account_id,
        public readonly string $account_type,
        public readonly string $display_name,
        public readonly string $currency,
        public readonly AccountNumberTL $account_number,
    )
    {
    }
}
