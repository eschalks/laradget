<?php

namespace App\TrueLayer;

use App\Money;
use App\MoneyTrueLayerCast;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class BalanceTL extends Data
{
    public function __construct(
        #[WithCast(MoneyTrueLayerCast::class)]
        public readonly Money            $current, #[WithCast(MoneyTrueLayerCast::class)]
        public readonly ?Money           $available=null, #[WithCast(MoneyTrueLayerCast::class)]
        public readonly ?Money           $overdraft=null, #[WithCast(DateTimeInterfaceCast::class, format: DATE_RFC3339_EXTENDED)]
        public readonly ?CarbonImmutable $update_timestamp = null,
    ) {
    }
}
