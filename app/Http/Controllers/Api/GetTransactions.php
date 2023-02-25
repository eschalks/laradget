<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiQueryBuilder;
use App\Data\Models\TransactionDto;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class GetTransactions extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $this->createTransactionsQuery($request);

        return response()->json(TransactionDto::collection($query->paginate()));
    }

    private function createTransactionsQuery(Request $request): Builder
    {
        return (new ApiQueryBuilder(Transaction::with('counterParty'), $request))
            ->addSort('transaction_at', 'desc')
            ->addFilter('category_id')
            ->addFilter('counter_party_id')
            ->addFilter('from', $this->addFromDate(...))
            ->addFilter('until', $this->addUntilDate(...))
            ->getQuery();
    }

    private function addFromDate(string $date, Builder $builder): void
    {
        $builder->where('transaction_at', '>=', $date);
    }

    private function addUntilDate(string $date, Builder $builder): void
    {
        $builder->where('transaction_at', '<=', $date);
    }
}
