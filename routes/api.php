<?php

use App\Http\Controllers\Api\GetCategories;
use App\Http\Controllers\Api\GetImportableAccounts;
use App\Http\Controllers\Api\GetPeriodSummary;
use App\Http\Controllers\Api\GetTransactions;
use App\Http\Controllers\Api\GetUncategorizedTransactions;
use App\Http\Controllers\Api\UpdateCounterPartyDefaultCategory;
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

Route::as('api.')->middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    Route::get('/import/accounts', GetImportableAccounts::class)
        ->name('import.accounts');
    Route::get('/transactions', GetTransactions::class)
        ->name('transactions');
    Route::get('/transactions/uncategorized', GetUncategorizedTransactions::class)
        ->name('transactions.uncategorized');
    Route::get('/summary/{start}/{end}', GetPeriodSummary::class)
        ->name('period_summary');
    Route::get('/categories', GetCategories::class)
        ->name('categories');

    Route::put('/transactions/{transaction}', UpdateTransaction::class)
        ->name('transactions.update');

    Route::put('/counter_parties/{counterParty}/default_category', UpdateCounterPartyDefaultCategory::class)
        ->name('counter_parties.default_category.update');
});

