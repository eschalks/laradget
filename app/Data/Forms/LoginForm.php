<?php

namespace App\Data\Forms;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class LoginForm extends Data
{
    public function __construct(
        #[Required]
        public readonly string $username, #[Required]
        public readonly string $password
    ) {
    }
}
