<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use App\TrueLayer\TrueLayerAuthenticator;
use App\TrueLayer\TrueLayerClient;

class FinishOAuth extends Controller
{
    public function __invoke(TrueLayerClient $trueLayerClient)
    {
        $trueLayerClient->authenticate();
        return redirect('/');
    }
}
