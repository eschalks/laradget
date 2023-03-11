<?php

namespace App\Http\Controllers\Api;

use App\Data\Models\TransactionDto;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class GetUncategorizedTransactions extends Controller
{
    public function __invoke()
    {
        $transactions = Transaction::whereNull('category_id')
            ->with('counterParty')
            ->get();

        return response()->json(TransactionDto::collection($transactions));
    }
}
