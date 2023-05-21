<?php

namespace App\Data\Models;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

class CounterPartyDto extends Data
{
    public function __construct(public readonly string $name)
    {
    }
}
