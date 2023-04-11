<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountProvider>
 */
class AccountProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'access_token'  => '::access_token::',
            'refresh_token' => '::refresh_token::',
            'expires_at'    => Carbon::now()
                                     ->addYear(),
            'is_active'     => true,
        ];
    }
}
