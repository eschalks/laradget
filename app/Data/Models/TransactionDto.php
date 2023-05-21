<?php

namespace App\Data\Models;

use App\Models\CounterParty;
use App\Money;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

class TransactionDto extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $description,
        public readonly Money $amount,
        #[MapInputName('transaction_at')]
        public readonly Carbon $transactionAt,
        #[MapInputName('counter_party')]
        public readonly ?CounterPartyDto $counterParty,
        #[MapInputName('category_id')]
        public readonly ?int $categoryId,
    )
    {
    }
}
