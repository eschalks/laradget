<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Budget\RedirectToCurrentMonth;
use Illuminate\Support\Facades\Auth;

class RedirectToStartPage extends Controller
{
    public function __invoke()
    {
        if (! Auth::check()) {
            return redirect()->action(ShowLoginForm::class);
        }


        return redirect()->action(RedirectToCurrentMonth::class);
    }
}
