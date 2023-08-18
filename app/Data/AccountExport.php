<?php

namespace App\Data;

use App\Models\Account;
use App\Models\CategoryGroup;
use App\Models\CounterParty;
use App\Models\Transaction;
use Illuminate\Support\Collection;

class AccountExport implements \JsonSerializable
{
    public function __construct(private readonly Account $account)
    {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'account'        => $this->serializeAccount(),
            'categoryGroups' => $this->serializeCategoryGroups(),
            'counterParties' => $this->serializeCounterParties(),
            'transactions'   => $this->serializeTransactions(),
        ];
    }

    private function serializeAccount(): array
    {
        return $this->account->only([
                                        'external_id',
                                        'name',
                                        'account_number',
                                        'currency',
                                        'balance',
                                        'balance_updated_at',
                                    ]);
    }

    private function serializeCategoryGroups(): Collection
    {
        return CategoryGroup::with('categories')
                            ->orderBy('seq')
                            ->select([
                                         'id',
                                         'name',
                                     ])
                            ->get()
                            ->map(function (CategoryGroup $categoryGroup) {
                                return [
                                    ...$categoryGroup->only(['id', 'name']),
                                    'categories' => $categoryGroup->categories->map->only([
                                                                                              'id',
                                                                                              'name',
                                                                                              'is_debit',
                                                                                              'month_offset',
                                                                                          ]),
                                ];
                            });
    }

    private function serializeCounterParties(): Collection
    {
        return CounterParty::select([
                                        'id',
                                        'name',
                                        'iban',
                                        'default_category_id',
                                    ])
                           ->get();
    }

    private function serializeTransactions(): Collection
    {
        return Transaction::with('month')
                          ->get()
                          ->map(function (Transaction $transaction) {
                              return [
                                  ...$transaction->only([
                                                            'id',
                                                            'external_id',
                                                            'category_id',
                                                            'counter_party_id',
                                                            'transaction_at',
                                                            'description',
                                                            'amount',
                                                            'currency',
                                                        ]),
                                  'month' => $transaction->month->starts_at->format('Y-m'),
                              ];
                          });
    }
}
