<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\CounterParty
 *
 * @property int                             $id
 * @property string                          $name
 * @property string                          $iban
 * @property int|null                        $default_category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty query()
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereDefaultCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CounterParty whereUpdatedAt($value)
 * @property-read Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @mixin \Eloquent
 */
class CounterParty extends AbstractModel
{
    /**
     * Updates the default category and all relevant associated transactions.
     * Returns a collection of all transactions that were updated.
     *
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction>
     * @throws \Throwable
     */
    public function updateDefaultCategory(
        Category $category
    ): Collection {
        return \DB::transaction(function () use ($category) {
            $transactionIds = $this->transactions()
                                 ->where(function (Builder $where) {
                                     $where->whereNull('category_id')
                                           ->orWhere('category_id', $this->default_category_id);
                                 })
                                 ->pluck('id');

            $this->update([
                              'default_category_id' => $category->getKey(),
                          ]);

            if ($transactionIds->isEmpty()) {
                return (new Transaction())->newCollection();
            }

            Transaction::whereIn('id', $transactionIds)->update(['category_id' => $category->getKey()]);
            return Transaction::findMany($transactionIds);
        });
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
