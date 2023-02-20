<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use App\TrueLayer\TrueLayerAuthenticator;
use App\TrueLayer\TrueLayerClient;

class StartOAuth extends Controller
{
    public function __invoke(TrueLayerClient $trueLayerClient)
    {
        return redirect($trueLayerClient->getAuthenticationUrl());
    }
}
