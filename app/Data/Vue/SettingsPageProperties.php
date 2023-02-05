<?php

namespace App\Data\Vue;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class SettingsPageProperties extends Data
{
    public function __construct(
        /** @var \App\Data\Vue\SettingsPageAccount[] */
        #[DataCollectionOf(SettingsPageAccount::class)]
        public readonly DataCollection $accounts,
        /** @var \App\Data\Vue\SettingsPagePersonalAccessToken[] */
        #[DataCollectionOf(SettingsPagePersonalAccessToken::class)]
        public readonly DataCollection $tokens,
    )
    {
    }
}
