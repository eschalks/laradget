<?php

namespace App\Http\Controllers\Budget;

use App\Data\Pages\BudgetPage;
use App\Data\Responses\PeriodSummary;
use App\Http\Controllers\Controller;
use App\Models\Month;
use App\Models\Transaction;
use App\Money;
use App\PeriodSummaryFactory;
use Carbon\CarbonImmutable;

class ShowMonthSummary extends Controller
{
    public function __invoke(PeriodSummaryFactory $periodSummaryFactory, int $year, int $month)
    {
        $date = CarbonImmutable::create($year, $month);

        $month = Month::findForDate($date);

        return BudgetPage::create($periodSummaryFactory->createForMonth($month));
    }
}
