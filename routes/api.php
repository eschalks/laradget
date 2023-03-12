<?php

use App\Http\Controllers\Api\GetCategories;
use App\Http\Controllers\Api\GetImportableAccounts;
use App\Http\Controllers\Api\GetPeriodSummary;
use App\Http\Controllers\Api\GetTransactions;
use App\Http\Controllers\Api\GetUncategorizedTransactions;
use App\Http\Controllers\Api\UpdateTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/import/accounts', GetImportableAccounts::class);
    Route::get('/transactions', GetTransactions::class);
    Route::get('/transactions/uncategorized', GetUncategorizedTransactions::class);
    Route::get('/summary/{start}/{end}', GetPeriodSummary::class);
    Route::get('/categories', GetCategories::class);

    Route::put('/transactions/{transaction}', UpdateTransaction::class);
});

