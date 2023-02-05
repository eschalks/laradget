<?php

namespace App\Http\Controllers\Api;

use App\Data\Models\TransactionDto;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class GetTransactions extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $this->createTransactionsQuery($request);

        return response()->json(TransactionDto::collection($query->paginate()));
    }

    private function createTransactionsQuery(Request $request)
    {
        return Transaction::with('counterParty')
            ->orderBy('transaction_at', 'desc');
    }
}
