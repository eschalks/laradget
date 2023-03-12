<?php

namespace App\Data\Api;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class UpdateTransactionDto extends Data
{
    public function __construct(
        public readonly int $categoryId,
        public readonly bool $updateCounterParty=false,
    )
    {
    }
}
