<?php

namespace App\Http\Controllers\Api;

use App\Data\Responses\PeriodSummary;
use App\Http\Controllers\Controller;
use App\PeriodSummaryFactory;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class GetPeriodSummary extends Controller
{
    public function __invoke(PeriodSummaryFactory $factory, string $start, string $end)
    {
        $startDate = CarbonImmutable::createFromFormat('Y-m', $start)->startOfMonth();
        $endDate = CarbonImmutable::createFromFormat('Y-m', $end)->endOfMonth();

        return $factory->createForRange($startDate, $endDate);
    }
}
