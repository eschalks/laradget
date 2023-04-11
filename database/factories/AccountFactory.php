<?php

namespace Database\Factories;

use App\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account_provider_id' => AccountProviderFactory::new(),
            'external_id'         => $this->faker->uuid,
            'name'                => $this->faker->name,
            'account_number'      => $this->faker->bankAccountNumber,
            'balance'             => Money::fromFloat(0),
            'currency'            => 'EUR',
            'balance_updated_at'  => now(),
        ];
    }
}
