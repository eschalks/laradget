<?php

namespace App;

use App\Data\Responses\PeriodSummary;
use App\Models\Month;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;

class PeriodSummaryFactory
{
    public function createForRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): PeriodSummary
    {
        // Database stores these as DATEs, so time should always be 00:00:00
        $startsAt = CarbonImmutable::instance($startDate)->startOfDay();
        $endsAt = CarbonImmutable::instance($endDate)->startOfDay();

        $months = Month::where('starts_at', '>=', $startsAt)
                       ->where('ends_at', '<=', $endsAt)
                       ->get();

        return new PeriodSummary($startDate, $endDate, $this->fetchTransactionTotals($months));
    }

    public function createForMonth(Month $month): PeriodSummary
    {
        return new PeriodSummary($month->starts_at, $month->ends_at,
                                 $this->fetchTransactionTotals($month->asCollection()));
    }

    private function fetchTransactionTotals(Collection $months): array
    {
        $existingMonths = $months->filter->exists;

        if ($existingMonths->isEmpty()) {
            return [];
        }

        return Transaction::whereIn('month_id', $existingMonths->modelKeys())
                          ->groupBy('category_id')
                          ->select([
                                       \DB::raw('SUM(amount) as amount'),
                                       'category_id',
                                   ])
                          ->pluck('amount', 'category_id')
                          ->all();
    }
}
