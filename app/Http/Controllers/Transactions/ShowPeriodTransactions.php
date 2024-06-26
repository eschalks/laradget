<?php

namespace App\Http\Controllers\Transactions;

use App\Data\Models\CategoryGroupDto;
use App\Data\Models\TransactionDto;
use App\Data\Pages\TransactionsPage;
use App\Http\Controllers\Controller;
use App\PeriodCollection;
use App\Models\CategoryGroup;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowPeriodTransactions extends Controller
{
    public function __invoke(Request $request)
    {
        $periods      = PeriodCollection::fromRoute($request->route());
        $transactions = Transaction::whereIn('month_id', $periods->modelKeys())
                                   ->with([
                                              'counterParty',
                                          ])
                                   ->orderByDesc('transaction_at')
                                   ->get();

        CategoryGroupDto::shareWithInertia();

        return TransactionsPage::from([
                                          'transactions' => $transactions,
                                      ]);
    }
}
