<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\TrueLayer\TrueLayerClient;

class GetImportableAccounts extends Controller
{
    public function __invoke(TrueLayerClient $trueLayerClient)
    {
        return response()->json($trueLayerClient->fetchAccounts());
    }
}
