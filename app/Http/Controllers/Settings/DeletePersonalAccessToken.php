<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Laravel\Sanctum\PersonalAccessToken;

class DeletePersonalAccessToken extends Controller
{
    public function __invoke(PersonalAccessToken $token)
    {
        $token->delete();
    }
}
