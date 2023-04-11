<?php

use Database\Factories\CategoryFactory;
use Database\Factories\TransactionFactory;



it('determines the month on the first save', function () {
    $category = CategoryFactory::new()
                               ->create([
                                            'month_offset' => 1,
                                        ]);

    $transactionAt = \Carbon\Carbon::create(2020, 1, 31);

    $transaction = TransactionFactory::new()
                                     ->create([
                                                  'category_id'    => $category->id,
                                                  'transaction_at' => $transactionAt,
                                              ]);


    $startOfMonth = $transaction->month->starts_at;

    expect($startOfMonth->year)->toBe(2020);
    expect($startOfMonth->month)->toBe(2);
});

it('updates the month when the category changes', function () {

    $transactionAt = \Carbon\Carbon::create(2020, 1, 31);

    $transaction = TransactionFactory::new()
                                     ->create([
                                                  'transaction_at' => $transactionAt,
                                              ]);


    $category = CategoryFactory::new()
                               ->create([
                                            'month_offset' => 1,
                                        ]);

    $transaction->update(['category_id' => $category->id]);

    $startOfMonth = $transaction->month->starts_at;
    expect($startOfMonth->year)->toBe(2020);
    expect($startOfMonth->month)->toBe(2);
});
