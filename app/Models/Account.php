<?php

namespace App\Models;

use App\Money;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Account
 *
 * @property int $id
 * @property int $account_provider_id
 * @property string $external_id
 * @property string $name
 * @property string $account_number
 * @property Money $balance
 * @property string $currency
 * @property \Illuminate\Support\Carbon $balance_updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAccountProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereBalanceUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Account extends AbstractModel
{

    protected $casts = [
        'balance' => Money::class,
        'balance_updated_at' => 'datetime',
    ];

    public function accountProvider(): BelongsTo
    {
        return $this->belongsTo(AccountProvider::class);
    }
}
