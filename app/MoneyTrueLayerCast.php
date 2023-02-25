<?php

namespace App;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class MoneyTrueLayerCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): Money
    {
        return Money::fromFloat($value);
    }
}
