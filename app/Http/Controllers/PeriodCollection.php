<?php

namespace App\Http\Controllers;

use App\Models\Month;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Route;

class PeriodCollection extends Collection
{
    public static function fromRoute(Route $route): static
    {
        $year       = $route->parameter('year');
        $startMonth = $route->parameter('month');
        $endMonth   = $startMonth;
        if ($startMonth === null) {
            $startMonth = 1;
            $endMonth   = 12;
        }

        $startsAt = Carbon::create($year, $startMonth)
                          ->startOfMonth();
        $endsAt   = Carbon::create($year, $endMonth)
                          ->endOfMonth();

        return Month::where('starts_at', '>=', $startsAt)
                    ->where('ends_at', '<=', $endsAt)
                    ->get();
    }
}
