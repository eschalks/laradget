<?php

namespace App\Models;

use App\Money;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $account_id
 * @property string $external_id
 * @property int $period_id
 * @property int|null $category_id
 * @property \Illuminate\Support\Carbon $transaction_at
 * @property string $description
 * @property Money $amount
 * @property string $currency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $month_id
 * @property int|null $counter_party_id
 * @property-read \App\Models\CounterParty|null $counterParty
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCounterPartyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMonthId($value)
 */
class Transaction extends AbstractModel
{
    protected $dates = [
        'transaction_at',
    ];

    protected $casts = [
        'amount' => Money::class,
    ];

    public function counterParty(): BelongsTo
    {
        return $this->belongsTo(CounterParty::class);
    }
}
