<?php

namespace App\Mcp\Tools;

use App\Models\Transaction;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Description('Read transactions for categorization or investigation. Defaults to uncategorized transactions; paginate with after_id. Amounts are signed decimal strings.')]
#[IsReadOnly]
class ListTransactions extends Tool
{
    public function schema(JsonSchema $schema): array
    {
        return [
            'uncategorized_only' => $schema->boolean()->description('Only transactions with no category; defaults to true.'),
            'from' => $schema->string()->description('First transaction date, YYYY-MM-DD.'),
            'to' => $schema->string()->description('Last transaction date, YYYY-MM-DD.'),
            'after_id' => $schema->integer()->description('Return records with ID greater than this value.'),
            'limit' => $schema->integer()->description('Maximum records, 1 to 100; defaults to 50.'),
        ];
    }

    public function handle(Request $request): ResponseFactory
    {
        $input = $request->validate([
            'uncategorized_only' => 'sometimes|boolean',
            'from' => 'sometimes|date_format:Y-m-d',
            'to' => 'sometimes|date_format:Y-m-d|after_or_equal:from',
            'after_id' => 'sometimes|integer|min:0',
            'limit' => 'sometimes|integer|between:1,100',
        ]);

        $query = Transaction::query()->with(['counterParty', 'category']);
        if ($input['uncategorized_only'] ?? true) {
            $query->whereNull('category_id');
        }
        if (isset($input['from'])) {
            $query->whereDate('transaction_at', '>=', $input['from']);
        }
        if (isset($input['to'])) {
            $query->whereDate('transaction_at', '<=', $input['to']);
        }
        if (isset($input['after_id'])) {
            $query->where('id', '>', $input['after_id']);
        }

        $limit = $input['limit'] ?? 50;
        $rows = $query->orderBy('id')->limit($limit + 1)->get();
        $hasMore = $rows->count() > $limit;
        $transactions = $rows->take($limit)->map(fn (Transaction $transaction) => [
            'id' => $transaction->id,
            'date' => $transaction->transaction_at->toDateString(),
            'description' => $transaction->description,
            'amount' => $transaction->amount->getValue(),
            'currency' => $transaction->currency,
            'counter_party' => $transaction->counterParty?->name,
            'category_id' => $transaction->category_id,
            'category' => $transaction->category?->name,
        ])->values()->all();

        return Response::structured([
            'transactions' => $transactions,
            'next_after_id' => $hasMore ? end($transactions)['id'] : null,
        ]);
    }
}
