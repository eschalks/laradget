<?php

namespace App;

use Illuminate\Contracts\Database\Eloquent\Castable;

class Money implements Castable, \JsonSerializable
{
    public function __construct(private readonly string $value)
    {
    }

    public static function castUsing(array $arguments): MoneyModelCast
    {
        return new MoneyModelCast();
    }

    public static function fromFloat(float $value): self
    {
        return new self((string)$value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
