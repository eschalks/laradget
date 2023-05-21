<?php

namespace App\Data\Pages;

use App\Data\Models\CounterPartyDetailsDto;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;
use Spatie\TypeScriptTransformer\Attributes\TypeScriptType;

class CounterPartiesPage extends AbstractPage
{
    public function __construct(
        #[DataCollectionOf(CounterPartyDetailsDto::class)]
        public readonly DataCollection $counterParties,
        #[TypeScriptType('Record<number, number>')]
        public readonly array          $uncategorizedTransactionCounts,
    )
    {
    }

    protected function getPageComponent(): string
    {
        return 'CounterPartiesPage';
    }
}
