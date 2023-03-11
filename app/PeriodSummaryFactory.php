<?php

namespace App;

use App\Data\Responses\PeriodSummary;
use App\Models\Month;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Collection;

class PeriodSummaryFactory
{
    public function createForRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): PeriodSummary
    {
        // Database stores these as DATEs, so time should always be 00:00:00
        $startsAt = CarbonImmutable::instance($startDate)
                                   ->startOfDay();
        $endsAt   = CarbonImmutable::instance($endDate)
                                   ->startOfDay();

        $transactionQuery = $this->createQueryForRange($startsAt, $endsAt);

        return $this->createSummary($startsAt, $endsAt, $transactionQuery);
    }

    public function createForMonth(Month $month): PeriodSummary
    {
        return $this->createSummary($month->starts_at, $month->ends_at, $month->transactions());
    }

    private function createSummary(
        \DateTimeInterface $startsAt,
        \DateTimeInterface $endsAt,
        BuilderContract    $transactionQuery
    ): PeriodSummary {
        $categoryTotals      = $this->fetchCategoryTotals($transactionQuery);
        $categoryGroupTotals = $this->fetchCategoryGroupTotals($transactionQuery);

        return new PeriodSummary($startsAt, $endsAt, $categoryTotals, $categoryGroupTotals);
    }

    private function fetchCategoryTotals(BuilderContract $transactionQuery): array
    {

        return (clone $transactionQuery)->groupBy('category_id')
                                        ->select([
                                                     \DB::raw('SUM(amount) as amount'),
                                                     'category_id',
                                                 ])
                                        ->pluck('amount', 'category_id')
                                        ->all();
    }

    private function fetchCategoryGroupTotals(BuilderContract $transactionQuery): array
    {
        return (clone $transactionQuery)->groupBy('category_group_id')
                                        ->join('categories', 'transactions.category_id', '=', 'categories.id')
                                        ->select([
                                                     \DB::raw('SUM(amount) as amount'),
                                                     'category_group_id',
                                                 ])
                                        ->pluck('amount', 'category_group_id')
                                        ->all();
    }

    private function createQueryForRange(CarbonImmutable $startsAt, CarbonImmutable $endsAt)
    {
        if ($startsAt->day === 1 && $endsAt->isLastOfMonth()) {
            $months = Month::where('starts_at', '>=', $startsAt)
                           ->where('ends_at', '<=', $endsAt)
                           ->get();

            return Transaction::whereIn('month_id', $months->modelKeys());
        }

        return Transaction::whereBetween('transaction_at', [$startsAt, $endsAt]);
    }
}
