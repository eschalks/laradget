<?php

namespace App\Mcp\Tools;

use App\Models\Transaction;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[Description('Analyze a date range of transactions by currency, category, month, and counterparty. Includes evidence-based review suggestions; treat transfers and incomplete categories carefully.')]
#[IsReadOnly]
class SpendingAnalysis extends Tool
{
    public function schema(JsonSchema $schema): array
    {
        return [
            'from' => $schema->string()->description('First transaction date, YYYY-MM-DD.')->required(),
            'to' => $schema->string()->description('Last transaction date, YYYY-MM-DD, at most 366 days after from.')->required(),
        ];
    }

    public function handle(Request $request): Response|ResponseFactory
    {
        $input = $request->validate([
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);

        $from = CarbonImmutable::createFromFormat('!Y-m-d', $input['from']);
        $to = CarbonImmutable::createFromFormat('!Y-m-d', $input['to']);
        if ($from->diffInDays($to) > 366) {
            return Response::error('Date range must be 366 days or shorter.');
        }

        $currencies = [];
        Transaction::query()->with(['category', 'counterParty'])
            ->whereBetween('transaction_at', [$from->startOfDay(), $to->endOfDay()])
            ->chunkById(500, function ($transactions) use (&$currencies) {
                foreach ($transactions as $transaction) {
                    $currency = $transaction->currency;
                    $cents = $this->toCents($transaction->amount->getValue());
                    $bucket = &$currencies[$currency];
                    $bucket ??= [
                        'income_cents' => 0,
                        'expense_cents' => 0,
                        'uncategorized_count' => 0,
                        'categories' => [],
                        'months' => [],
                        'counter_parties' => [],
                    ];

                    if ($cents >= 0) {
                        $bucket['income_cents'] += $cents;
                    } else {
                        $bucket['expense_cents'] += -$cents;
                    }
                    if ($transaction->category_id === null) {
                        $bucket['uncategorized_count']++;
                    }

                    $this->addGroup($bucket['categories'], (string) ($transaction->category_id ?? 'uncategorized'),
                        $transaction->category?->name ?? 'Uncategorized', $cents);
                    $this->addGroup($bucket['months'], $transaction->transaction_at->format('Y-m'),
                        $transaction->transaction_at->format('Y-m'), $cents);
                    if ($transaction->counter_party_id !== null) {
                        $this->addGroup($bucket['counter_parties'], (string) $transaction->counter_party_id,
                            $transaction->counterParty?->name ?? 'Unknown', $cents);
                    }
                    unset($bucket);
                }
            });

        $results = [];
        foreach ($currencies as $currency => $bucket) {
            $categories = $this->formatGroups($bucket['categories']);
            $months = $this->formatGroups($bucket['months']);
            $counterParties = $this->formatGroups($bucket['counter_parties']);
            usort($categories, fn ($a, $b) => $b['expense_cents'] <=> $a['expense_cents']);
            usort($counterParties, fn ($a, $b) => $b['expense_cents'] <=> $a['expense_cents']);
            usort($months, fn ($a, $b) => strcmp($a['key'], $b['key']));

            $advice = [];
            if ($bucket['uncategorized_count'] > 0) {
                $advice[] = $bucket['uncategorized_count'].' uncategorized transactions should be reviewed before relying on category totals.';
            }
            $largestCategorizedExpense = collect($categories)->first(fn ($row) => $row['key'] !== 'uncategorized' && $row['expense_cents'] > 0);
            if ($largestCategorizedExpense) {
                $advice[] = 'Review '.$largestCategorizedExpense['name'].' first: it has the highest categorized expenses in this period.';
            }
            if ($bucket['expense_cents'] > $bucket['income_cents']) {
                $advice[] = 'Recorded expenses exceed recorded income for this period. Check transfers and missing accounts before drawing conclusions.';
            }

            $results[$currency] = [
                'income' => $this->fromCents($bucket['income_cents']),
                'expenses' => $this->fromCents($bucket['expense_cents']),
                'net' => $this->fromCents($bucket['income_cents'] - $bucket['expense_cents']),
                'uncategorized_count' => $bucket['uncategorized_count'],
                'categories' => array_map(fn ($row) => $this->moneyRow($row), $categories),
                'months' => array_map(fn ($row) => $this->moneyRow($row), $months),
                'top_counter_parties' => array_map(fn ($row) => $this->moneyRow($row), array_slice($counterParties, 0, 10)),
                'review_suggestions' => $advice,
            ];
        }

        return Response::structured([
            'from' => $input['from'],
            'to' => $input['to'],
            'basis' => 'Transaction date; negative amounts are expenses. Transfers are not identified automatically.',
            'currencies' => $results ?: (object) [],
        ]);
    }

    private function addGroup(array &$groups, string $key, string $name, int $cents): void
    {
        $groups[$key] ??= ['key' => $key, 'name' => $name, 'income_cents' => 0, 'expense_cents' => 0];
        if ($cents >= 0) {
            $groups[$key]['income_cents'] += $cents;
        } else {
            $groups[$key]['expense_cents'] += -$cents;
        }
    }

    private function formatGroups(array $groups): array
    {
        return array_values($groups);
    }

    private function moneyRow(array $row): array
    {
        return [
            'key' => $row['key'],
            'name' => $row['name'],
            'income' => $this->fromCents($row['income_cents']),
            'expenses' => $this->fromCents($row['expense_cents']),
            'net' => $this->fromCents($row['income_cents'] - $row['expense_cents']),
        ];
    }

    private function toCents(string $amount): int
    {
        $negative = str_starts_with($amount, '-');
        [$units, $fraction] = array_pad(explode('.', ltrim($amount, '-'), 2), 2, '');
        $cents = (int) $units * 100 + (int) str_pad(substr($fraction, 0, 2), 2, '0');

        return $negative ? -$cents : $cents;
    }

    private function fromCents(int $cents): string
    {
        return ($cents < 0 ? '-' : '').intdiv(abs($cents), 100).'.'.str_pad((string) (abs($cents) % 100), 2, '0', STR_PAD_LEFT);
    }
}
