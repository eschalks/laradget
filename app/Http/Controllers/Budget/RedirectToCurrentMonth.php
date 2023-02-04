<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectToCurrentMonth extends Controller
{
    public function __invoke(Request $request)
    {
        $today = today();
        $url = $request->url();

        return redirect("$url/$today->year/$today->month");
    }
}
