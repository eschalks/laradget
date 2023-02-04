<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ShowLoginForm extends Controller
{
    public function __invoke()
    {
        return Inertia::render('LoginPage');
    }
}
