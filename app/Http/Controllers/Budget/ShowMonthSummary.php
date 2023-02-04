<?php

namespace App\Http\Controllers\Budget;

use App\Data\Responses\PeriodSummary;
use App\Http\Controllers\Controller;
use App\Models\Month;
use App\Models\Transaction;
use App\Money;
use Carbon\CarbonImmutable;

class ShowMonthSummary extends Controller
{
    public function __invoke(int $year, int $month)
    {
        $date = CarbonImmutable::create($year, $month);

        $month = Month::findForDate($date);

        $summary = new PeriodSummary($month->starts_at, $month->ends_at, $this->fetchTransactionTotals($month));

        return new BudgetPageResponse($summary);
    }

    private function fetchTransactionTotals(Month $period): array
    {
        if (! $period->exists) {
            return [];
        }

        return Transaction::whereMonthId($period->getKey())
                          ->groupBy('category_id')
                          ->select([
                                       \DB::raw('SUM(amount) as amount'),
                                       'category_id',
                                   ])
                          ->pluck('amount', 'category_id')
                          ->all();
    }
}
