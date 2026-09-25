<?php

namespace App\Mcp\Tools;

use App\Models\Transaction;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\DB;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Assign one category to up to 50 transaction IDs. Existing categories are protected unless overwrite is true. Updates are atomic and recalculate budget months.')]
class CategorizeTransactions extends Tool
{
    public function schema(JsonSchema $schema): array
    {
        return [
            'transaction_ids' => $schema->array()->items($schema->integer())->description('Transaction IDs to categorize, maximum 50.')->required(),
            'category_id' => $schema->integer()->description('Existing category ID.')->required(),
            'overwrite' => $schema->boolean()->description('Allow replacing existing categories; defaults to false.'),
        ];
    }

    public function handle(Request $request): Response|ResponseFactory
    {
        $input = $request->validate([
            'transaction_ids' => 'required|array|between:1,50',
            'transaction_ids.*' => 'required|integer|distinct|exists:transactions,id',
            'category_id' => 'required|integer|exists:categories,id',
            'overwrite' => 'sometimes|boolean',
        ]);

        return DB::transaction(function () use ($input) {
            $transactions = Transaction::query()
                ->whereIn('id', $input['transaction_ids'])
                ->lockForUpdate()
                ->get();

            if ($transactions->count() !== count($input['transaction_ids'])) {
                return Response::error('One or more transactions no longer exist. Reload the transaction list and try again.');
            }

            $protected = $transactions->filter(fn (Transaction $transaction) => $transaction->category_id !== null
                && $transaction->category_id !== $input['category_id']);

            if ($protected->isNotEmpty() && !($input['overwrite'] ?? false)) {
                return Response::error('Already categorized transaction IDs: '.$protected->pluck('id')->implode(', ').'. Set overwrite=true to replace them.');
            }

            foreach ($transactions as $transaction) {
                $transaction->category_id = $input['category_id'];
                $transaction->save();
            }

            return Response::structured([
                'updated_transaction_ids' => $transactions->pluck('id')->all(),
                'category_id' => $input['category_id'],
            ]);
        });
    }
}
