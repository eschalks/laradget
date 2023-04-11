<?php

use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Database\Factories\TransactionFactory;

it('updates all related categories on month_offset change', function () {
    $transactionAt = Carbon::create(2020, 1, 31);

    $category = CategoryFactory::new()
                               ->create([
                                            'month_offset' => 0,
                                        ]);

    $transactions = TransactionFactory::new()
                                      ->count(10)
                                      ->create([
                                                   'transaction_at' => $transactionAt,
                                                   'category_id'    => $category,
                                               ]);

    $category->update(['month_offset' => 2]);

    foreach ($transactions as $transaction) {
        $transaction->refresh();

        $startOfMonth = $transaction->month->starts_at;
        expect($startOfMonth->year)->toBe(2020);
        expect($startOfMonth->month)->toBe(3);
    }
});
