<?php

namespace App\Data\Responses;

use Spatie\LaravelData\Data;

class PeriodRange extends Data
{
    public function __construct(
        public readonly \DateTimeInterface $startsAt,

    )
    {

    }
}
