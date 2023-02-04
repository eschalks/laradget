<?php

namespace App;

use Illuminate\Contracts\Database\Eloquent\Castable;

class Money implements Castable, \JsonSerializable
{
    public function __construct(private readonly int $value)
    {
    }

    public static function castUsing(array $arguments): MoneyModelCast
    {
        return new MoneyModelCast();
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }
}
