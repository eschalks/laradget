<?php

namespace App\Data\Pages;

use App\Data\Vue\SettingsPageAccount;
use App\Data\Vue\SettingsPagePersonalAccessToken;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

class SettingsPage extends AbstractPage
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

    protected function getPageComponent(): string
    {
        return 'SettingsPage';
    }
}
