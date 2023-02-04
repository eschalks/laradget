<?php

namespace App\TrueLayer;

use Spatie\LaravelData\Data;

class TokenResponse extends Data
{
    public function __construct(
        public readonly string $access_token,
        public readonly string $refresh_token,
        public readonly int $expires_in,
    )
    {
    }
}
