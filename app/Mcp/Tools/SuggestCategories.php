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

#[Description('Suggest categories for uncategorized transactions from a counterparty default or categorized transactions with the same counterparty. Returns evidence, not automatic changes.')]
#[IsReadOnly]
class SuggestCategories extends Tool
{
    public function schema(JsonSchema $schema): array
    {
        return [
            'limit' => $schema->integer()->description('Maximum uncategorized transactions to inspect, 1 to 100; defaults to 50.'),
            'after_id' => $schema->integer()->description('Inspect transactions with ID greater than this value.'),
        ];
    }

    public function handle(Request $request): ResponseFactory
    {
        $input = $request->validate([
            'limit' => 'sometimes|integer|between:1,100',
            'after_id' => 'sometimes|integer|min:0',
        ]);

        $query = Transaction::query()->whereNull('category_id')->with('counterParty')->orderBy('id');
        if (isset($input['after_id'])) {
            $query->where('id', '>', $input['after_id']);
        }

        $limit = $input['limit'] ?? 50;
        $rows = $query->limit($limit + 1)->get();
        $hasMore = $rows->count() > $limit;
        $suggestions = [];
        $history = [];

        foreach ($rows->take($limit) as $transaction) {
            $party = $transaction->counterParty;
            $suggestion = null;

            if ($party?->default_category_id) {
                $suggestion = [
                    'category_id' => $party->default_category_id,
                    'reason' => 'Counterparty default category',
                    'matching_transactions' => null,
                ];
            } elseif ($party) {
                $counts = $history[$party->id] ??= Transaction::query()
                    ->where('counter_party_id', $party->id)
                    ->whereNotNull('category_id')
                    ->selectRaw('category_id, COUNT(*) as count')
                    ->groupBy('category_id')
                    ->orderByDesc('count')
                    ->get();

                if ($counts->count() === 1) {
                    $suggestion = [
                        'category_id' => $counts->first()->category_id,
                        'reason' => 'All categorized transactions with this counterparty use this category',
                        'matching_transactions' => (int) $counts->first()->count,
                    ];
                }
            }

            $suggestions[] = [
                'transaction_id' => $transaction->id,
                'description' => $transaction->description,
                'counter_party' => $party?->name,
                'suggestion' => $suggestion,
            ];
        }

        return Response::structured([
            'suggestions' => $suggestions,
            'next_after_id' => $hasMore ? end($suggestions)['transaction_id'] : null,
        ]);
    }
}
