<?php

use App\Mcp\Servers\FinanceServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/finance', FinanceServer::class)
    ->middleware(['auth:sanctum', 'throttle:api']);
