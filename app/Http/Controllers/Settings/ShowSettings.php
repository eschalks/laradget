<?php

namespace App\Http\Controllers\Settings;

use App\Data\Vue\SettingsPageProperties;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;

class ShowSettings extends Controller
{
    public function __invoke()
    {
        return Inertia::render('SettingsPage', SettingsPageProperties::from([
                                                                                'accounts' => Account::all(),
                                                                                'tokens'   => PersonalAccessToken::all(),
                                                                            ]));
    }
}
