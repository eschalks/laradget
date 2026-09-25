<?php

use App\Mcp\Servers\FinanceServer;
use App\Mcp\Tools\CategorizeTransactions;
use App\Mcp\Tools\ListTransactions;
use App\Mcp\Tools\SpendingAnalysis;
use App\Mcp\Tools\SuggestCategories;
use App\Money;
use Database\Factories\CategoryFactory;
use Database\Factories\TransactionFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

it('requires authentication for the web MCP endpoint', function () {
    $this->postJson('/mcp/finance', [
        'jsonrpc' => '2.0',
        'id' => 1,
        'method' => 'initialize',
        'params' => [
            'protocolVersion' => '2025-11-25',
            'capabilities' => (object) [],
            'clientInfo' => ['name' => 'test', 'version' => '1.0'],
        ],
    ])->assertUnauthorized();
});

it('uses counterparty history to suggest a category without changing the transaction', function () {
    $category = CategoryFactory::new()->create();
    $known = TransactionFactory::new()->create(['category_id' => $category->id]);
    $party = \App\Models\CounterParty::create(['name' => 'Shop']);
    $known->update(['counter_party_id' => $party->id]);
    $unknown = TransactionFactory::new()->create([
        'category_id' => null,
        'counter_party_id' => $party->id,
    ]);

    FinanceServer::tool(SuggestCategories::class)->assertStructuredContent(
        fn (AssertableJson $json) => $json->has('suggestions', 1)
            ->where('suggestions.0.transaction_id', $unknown->id)
            ->where('suggestions.0.suggestion.category_id', $category->id)
            ->etc()
    );

    expect($unknown->fresh()->category_id)->toBeNull();
});

it('pages uncategorized transactions without leaking categorized ones', function () {
    $first = TransactionFactory::new()->create(['category_id' => null]);
    $second = TransactionFactory::new()->create(['category_id' => null]);
    TransactionFactory::new()->create();

    FinanceServer::tool(ListTransactions::class, ['limit' => 1])
        ->assertStructuredContent(fn (AssertableJson $json) => $json
            ->has('transactions', 1)
            ->where('transactions.0.id', $first->id)
            ->where('next_after_id', $first->id)
            ->etc());

    FinanceServer::tool(ListTransactions::class, ['limit' => 1, 'after_id' => $first->id])
        ->assertStructuredContent(fn (AssertableJson $json) => $json
            ->has('transactions', 1)
            ->where('transactions.0.id', $second->id)
            ->where('next_after_id', null)
            ->etc());
});

it('protects existing categories and recalculates budget months when categorizing', function () {
    $original = CategoryFactory::new()->create();
    $nextMonth = CategoryFactory::new()->create(['month_offset' => 1]);
    $uncategorized = TransactionFactory::new()->create([
        'category_id' => null,
        'transaction_at' => '2024-01-31',
    ]);
    $categorized = TransactionFactory::new()->create(['category_id' => $original->id]);

    FinanceServer::tool(CategorizeTransactions::class, [
        'transaction_ids' => [$uncategorized->id, $categorized->id],
        'category_id' => $nextMonth->id,
    ])->assertHasErrors(['Already categorized']);

    expect($uncategorized->fresh()->category_id)->toBeNull();
    expect($categorized->fresh()->category_id)->toBe($original->id);

    FinanceServer::tool(CategorizeTransactions::class, [
        'transaction_ids' => [$uncategorized->id],
        'category_id' => $nextMonth->id,
    ])->assertOk();

    expect($uncategorized->fresh()->category_id)->toBe($nextMonth->id);
    expect($uncategorized->fresh()->month->starts_at->format('Y-m'))->toBe('2024-02');
});

it('keeps currencies separate and reports expenses as decimal strings', function () {
    TransactionFactory::new()->create([
        'transaction_at' => '2024-04-12',
        'amount' => Money::fromFloat(-12.50),
        'currency' => 'EUR',
    ]);
    TransactionFactory::new()->create([
        'transaction_at' => '2024-04-13',
        'amount' => Money::fromFloat(4.25),
        'currency' => 'EUR',
    ]);
    TransactionFactory::new()->create([
        'transaction_at' => '2024-04-14',
        'amount' => Money::fromFloat(-7.00),
        'currency' => 'USD',
    ]);

    FinanceServer::tool(SpendingAnalysis::class, [
        'from' => '2024-04-01',
        'to' => '2024-04-30',
    ])->assertStructuredContent(
        fn (AssertableJson $json) => $json
            ->where('currencies.EUR.income', '4.25')
            ->where('currencies.EUR.expenses', '12.50')
            ->where('currencies.EUR.net', '-8.25')
            ->where('currencies.USD.expenses', '7.00')
            ->etc()
    );
});
