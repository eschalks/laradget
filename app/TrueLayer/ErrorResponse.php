<?php

namespace App\TrueLayer;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class ErrorResponse extends Data
{
    public function __construct(
        public readonly TrueLayerError $error,
        #[MapInputName('error_description')]
        public readonly string $errorDescription,
    )
    {
    }
}
