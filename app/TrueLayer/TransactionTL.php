<?php

namespace App\TrueLayer;

use App\Money;
use App\MoneyTrueLayerCast;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 *     val transaction_id: String,
 * val timestamp: ZonedDateTimeIso,
 * val description: String,
 * val amount: BigDecimalAsNumber,
 * val currency: String,
 * val transaction_type: String,
 * val transaction_category: String,
 * val transaction_classification: List<String>,
 * val meta:  TransactionMetadata,
 * val merchant_name: String? = null,
 * val running_balance: RunningBalance? = null,
 * val provider_transaction_id: String? = null,
 * val normalised_provider_transaction_id: String? = null,
 */
class TransactionTL extends Data
{
    public function __construct(
        public readonly string          $transaction_id,
        #[WithCast(DateTimeInterfaceCast::class, format: DATE_RFC3339)]
        public readonly CarbonImmutable $timestamp,
        public readonly string          $description,
        #[WithCast(MoneyTrueLayerCast::class)]
        public readonly Money           $amount,
        public readonly string          $currency,
        public readonly TransactionMeta $meta,
    ) {
    }
}
