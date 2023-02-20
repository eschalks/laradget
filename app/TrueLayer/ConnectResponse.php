<?php

namespace App\TrueLayer;

use Spatie\LaravelData\Data;

class ConnectResponse extends Data
{
    public function __construct(
        public readonly string $access_token,
        public readonly string $token_type,
        public readonly int $expires_in,
        public readonly string $refresh_token,
        public readonly string $scope,
    )
    {
    }
}
