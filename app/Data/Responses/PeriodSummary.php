<?php

namespace App\Data\Responses;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PeriodSummary extends Data
{
    public function __construct(
        public readonly \DateTimeInterface $startsAt,
        public readonly \DateTimeInterface $endsAt,
        #[LiteralTypeScriptType('Record<number, number>')]
        public readonly array              $transactionTotals,
    ) {
    }
}
