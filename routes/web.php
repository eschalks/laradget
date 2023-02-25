<?php

use App\Http\Controllers\Budget\RedirectToCurrentMonth;
use App\Http\Controllers\Budget\ShowMonthSummary;
use App\Http\Controllers\Budget\ShowRangeSummary;
use App\Http\Controllers\CounterParties\ShowCounterParties;
use App\Http\Controllers\CounterParties\UpdateCounterParty;
use App\Http\Controllers\OAuth\FinishOAuth;
use App\Http\Controllers\OAuth\StartOAuth;
use App\Http\Controllers\PostLogin;
use App\Http\Controllers\RedirectToStartPage;
use App\Http\Controllers\Settings\CreatePersonalAccessToken;
use App\Http\Controllers\Settings\DeletePersonalAccessToken;
use App\Http\Controllers\Settings\ImportAccount;
use App\Http\Controllers\Settings\ShowAccountImport;
use App\Http\Controllers\Settings\ShowPersonalAccessTokenForm;
use App\Http\Controllers\Settings\ShowSettings;
use App\Http\Controllers\ShowBudget;
use App\Http\Controllers\ShowLoginForm;
use App\Http\Controllers\Transactions\ShowPeriodTransactions;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', RedirectToStartPage::class);
Route::get('/login', ShowLoginForm::class)->name('login');
Route::post('/login', PostLogin::class);

Route::middleware(['auth'])->group(function() {
    Route::get('oauth', StartOAuth::class)->name('oauth.start');
    Route::get('oauth/callback', FinishOAuth::class)->name('oauth.callback');

    Route::prefix('/budget')->group(function () {
        Route::get('', RedirectToCurrentMonth::class);

        Route::get('/range/{startDate}/{endDate?}', ShowRangeSummary::class);
        Route::get('/{year}/{month?}', ShowMonthSummary::class);
    });

    Route::prefix('/transactions')->group(static function () {
        Route::get('', RedirectToCurrentMonth::class);
        Route::get('/{year}/{month?}', ShowPeriodTransactions::class);
    });

    Route::prefix('/counter_parties')->group(static function() {
        Route::get('', ShowCounterParties::class);
        Route::prefix('/{counter_party}')->group(static function() {
            Route::put('', UpdateCounterParty::class);
        });

    });

    Route::prefix('/settings')->group(function() {
       Route::get('', ShowSettings::class);
       Route::get('/accounts/import', ShowAccountImport::class);
       Route::post('/accounts/import', ImportAccount::class);

       Route::get('/tokens/create', ShowPersonalAccessTokenForm::class);
       Route::post('/tokens/create', CreatePersonalAccessToken::class);
       Route::delete('/tokens/{token}', DeletePersonalAccessToken::class);
    });
});
