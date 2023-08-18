<?php

namespace App\Http\Controllers\Settings;

use App\Data\AccountExport;
use App\Http\Controllers\Controller;
use App\Models\Account;

class ExportAccount extends Controller
{
    public function __invoke(Account $account)
    {
        return response()->json(new AccountExport($account), headers: [
            'Content-Disposition' => sprintf('attachment; filename="export.%s.json"', today()->format('Ymd')),
        ], options: JSON_PRETTY_PRINT);
    }
}
