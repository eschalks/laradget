<?php

namespace App;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class MoneyModelCast implements CastsAttributes
{
    public function __construct()
    {
    }

    public function get($model, string $key, $value, array $attributes)
    {
        return new Money($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return expect(Money::class, $value)->getValue();
    }
}
