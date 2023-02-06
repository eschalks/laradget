<?php

namespace App\Data\Vue;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class SettingsPagePersonalAccessToken extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    )
    {
    }
}