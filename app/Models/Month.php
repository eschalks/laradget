<?php

namespace App\Models;

use App\Http\Controllers\PeriodCollection;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Period
 *
 * @property int                        $id
 * @property \Illuminate\Support\Carbon $starts_at
 * @property \Illuminate\Support\Carbon $ends_at
 * @method static \Illuminate\Database\Eloquent\Builder|Month newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Month newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Month query()
 * @method static \Illuminate\Database\Eloquent\Builder|Month whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Month whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Month whereStartsAt($value)
 * @method static PeriodCollection|static[] all($columns = ['*'])
 * @method static PeriodCollection|static[] get($columns = ['*'])
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @mixin \Eloquent
 */
class Month extends AbstractModel
{
    public $timestamps = false;

    protected $casts = [
        'starts_at' => 'immutable_date',
        'ends_at' => 'immutable_date',
    ];

    public static function findOrCreateForDate(\DateTimeInterface $dateTime): self
    {
        return Month::firstOrCreate(self::createQueryDates($dateTime));
    }

    public static function findForDate(\DateTimeInterface $dateTime): self
    {
        return Month::firstOrNew(self::createQueryDates($dateTime));
    }

    private static function createQueryDates(\DateTimeInterface $dateTime): array
    {
        $startsAt = CarbonImmutable::instance($dateTime)
                                   ->startOfMonth();
        $endsAt   = $startsAt->endOfMonth()->startOfDay();

        return [
            'starts_at' => $startsAt,
            'ends_at'   => $endsAt,
        ];
    }

    public function newCollection(array $models = [])
    {
        return new PeriodCollection($models);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
