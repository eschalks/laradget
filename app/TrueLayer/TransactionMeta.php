<?php

namespace App\TrueLayer;

use Spatie\LaravelData\Data;

class TransactionMeta extends Data
{
    public function __construct(
        public readonly string  $counter_party_preferred_name = '',
        public readonly ?string $counter_party_preferred_iban = null,

    ) {
    }
}
