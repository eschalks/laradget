<?php

namespace App\Data\Responses;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

class PeriodSummary extends Data
{
    public function __construct(
        public readonly \DateTimeInterface $startsAt,
        public readonly \DateTimeInterface $endsAt,
        #[LiteralTypeScriptType('Record<number, number>')]
        public readonly array              $categoryTotals,
        #[LiteralTypeScriptType('Record<number, number>')]
        public readonly array              $categoryGroupTotals,
    ) {
    }
}
