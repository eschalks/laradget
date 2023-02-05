<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ShowPersonalAccessTokenForm extends Controller
{
    public function __invoke()
    {
        return Inertia::render('CreatePersonalAccessTokenPage');
    }
}
