<?php

namespace App\Http\Controllers\Settings;

use App\Data\Pages\SettingsPage;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Laravel\Sanctum\PersonalAccessToken;

class ShowSettings extends Controller
{
    public function __invoke()
    {
        return SettingsPage::from([
                                                'accounts' => Account::all(),
                                                'tokens'   => PersonalAccessToken::all(),
                                            ]);
    }
}
