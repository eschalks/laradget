# Finance MCP server

The official `laravel/mcp` package serves this app's tools at `/mcp/finance`. Use PHP 8.3 or newer and run `composer install` after pulling this branch. The server requires a Sanctum personal access token from the app's Settings page. Configure an MCP client for Streamable HTTP with:

- URL: `https://YOUR_APP_HOST/mcp/finance`
- Header: `Authorization: Bearer YOUR_TOKEN`

Available tools:

| Tool | Purpose |
| --- | --- |
| `list-categories` | Discover category IDs and budget month offsets. |
| `list-transactions` | Read up to 100 transactions per page; uncategorized by default. |
| `suggest-categories` | Find conservative suggestions from counterparty defaults and unanimous categorized history. It does not change data. |
| `categorize-transactions` | Set a category on up to 50 transactions atomically. Existing categories require `overwrite: true`. |
| `spending-analysis` | Summarize income, expenses, months, categories, and counterparties for up to 366 days. |

Amounts are signed decimal strings, grouped by currency. Negative amounts represent expenses. Spending analysis uses transaction dates; the app's budget months may differ when a category has a month offset. The review suggestions are prompts for investigation, not a complete financial plan. Transfers and missing accounts are not identified automatically.

To verify the feature in a PHP 8.3 environment with SQLite enabled, run `composer install`, `php artisan test`, and `npm run build`.
