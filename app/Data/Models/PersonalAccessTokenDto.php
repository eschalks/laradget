<?php

namespace App\Data\Models;

use Spatie\LaravelData\Data;

class PersonalAccessTokenDto extends Data
{
    public function __construct(
        int $id,
        string $name,
        string $token,
    )
    {
    }
}
