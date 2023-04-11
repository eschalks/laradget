<?php

namespace App\Models;

use App\Attributes\OnChangeTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * App\Models\Category
 *
 * @property int                                                                         $id
 * @property int                                                                         $category_group_id
 * @property string                                                                      $name
 * @property int                                                                         $seq
 * @property \Illuminate\Support\Carbon|null                                             $created_at
 * @property \Illuminate\Support\Carbon|null                                             $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @property int                                                                         $is_debit
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsDebit($value)
 * @property int                                                                         $month_offset
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null                                                               $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMonthOffset($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @mixin \Eloquent
 */
class Category extends AbstractModel
{
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    #[OnChangeTo('month_offset', beforeSave: false)]
    private function updateTransactionDates(): void
    {
        \DB::transaction(function () {
            // Using ->get() to make sure we always get the most up-to-date list of transactions
            /** @var \App\Models\Transaction $transaction */
            foreach ($this->transactions()->get() as $transaction) {
                $transaction->moveToExpectedMonth();
                $transaction->save();
            }
        });
    }
}
