<?php

namespace Database\Factories;

use App\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account_id'     => AccountFactory::new(),
            'category_id'    => CategoryFactory::new(),
            'external_id'    => $this->faker->uuid,
            'amount'         => Money::fromFloat($this->faker->randomFloat(2, -1000, 1000)),
            'transaction_at' => $this->faker->dateTime,
            'description'    => $this->faker->sentence,
            'currency'       => 'EUR',
        ];
    }
}
