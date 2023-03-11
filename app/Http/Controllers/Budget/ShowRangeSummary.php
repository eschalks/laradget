<?php

namespace App\Http\Controllers\Budget;

use App\Data\Responses\PeriodSummary;
use App\Http\Controllers\Controller;
use App\Models\Month;
use App\Models\Transaction;
use App\PeriodSummaryFactory;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

class ShowRangeSummary extends Controller
{
    public function __invoke(PeriodSummaryFactory $periodSummaryFactory, string $startDate, ?string $endDate = null)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = ($endDate ? Carbon::parse($endDate) : today())->endOfDay();


        $summary = $periodSummaryFactory->createForRange($start, $end);
        return new BudgetPageResponse($summary);
    }

    private function fetchTransactionTotals(\DateTimeInterface $start, \DateTimeInterface $end): array
    {
        return Transaction::whereBetween('transaction_at', [$start, $end])
                          ->groupBy('category_id')
                          ->select([
                                       \DB::raw('SUM(amount) as amount'),
                                       'category_id',
                                   ])
                          ->pluck('amount', 'category_id')
                          ->all();
    }
}
