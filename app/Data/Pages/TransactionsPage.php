<?php

namespace App\Data\Pages;

use App\Data\Models\TransactionDto;
use App\Models\Transaction;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

class TransactionsPage extends AbstractPage
{
    public function __construct(
        #[DataCollectionOf(TransactionDto::class)]
        public readonly DataCollection $transactions,
    )
    {
    }

    protected function getPageComponent(): string
    {
        return 'TransactionsPage';
    }
}
