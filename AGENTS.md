# Project notes for agents

- This is a Laravel 13 application targeting PHP 8.3 with a Vue frontend. API routes live in `routes/api.php` and use Sanctum bearer tokens.
- The HTTP MCP server is registered in `routes/ai.php` with tools under `app/Mcp`.
- Financial amounts are stored as decimal values and cast to `App\Money`. Keep them as decimal strings in API output; group totals by currency.
- Categorizing a transaction through its Eloquent model also recalculates its budget month, including the category's `month_offset`. Avoid bulk SQL updates for category changes.
- Feature tests use Pest and model factories under `database/factories`. Run `php artisan test` with PHP 8.3 and the SQLite extension after changing server behavior.
- Do not use or modify the untracked database backup and SQL dump in the repository root.
