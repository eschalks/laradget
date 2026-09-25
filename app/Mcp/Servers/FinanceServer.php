<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\CategorizeTransactions;
use App\Mcp\Tools\ListCategories;
use App\Mcp\Tools\ListTransactions;
use App\Mcp\Tools\SuggestCategories;
use App\Mcp\Tools\SpendingAnalysis;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('Laradget Finance')]
#[Version('1.0.0')]
#[Instructions('Use transaction evidence to suggest categories and spending advice. Suggestions are tentative. Ask the user before calling categorize-transactions. Amounts are decimal strings in their original currencies; negative amounts are expenses. Spending analysis uses transaction dates, while budget months can differ because of category offsets.')]
class FinanceServer extends Server
{
    protected array $tools = [
        ListCategories::class,
        ListTransactions::class,
        SuggestCategories::class,
        CategorizeTransactions::class,
        SpendingAnalysis::class,
    ];
}
