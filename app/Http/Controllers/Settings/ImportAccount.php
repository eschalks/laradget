<?php

namespace App\Http\Controllers\Settings;

use App\Data\Forms\ImportAccountForm;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\TrueLayer\AccountTL;
use App\TrueLayer\TrueLayerClient;
use Assert\Assertion;

class ImportAccount extends Controller
{
    public function __construct(private readonly TrueLayerClient $trueLayerClient)
    {
    }

    public function __invoke(ImportAccountForm $accountForm)
    {

        \DB::transaction(function () use ($accountForm) {
            $remoteAccounts = $this->trueLayerClient->fetchAccounts()
                                                    ->toCollection()
                                                    ->keyBy('account_id');

            foreach ($accountForm->accounts as $accountId) {
                $remoteAccount = $remoteAccounts[$accountId] ?? null;

                if ($remoteAccount) {
                    $this->importAccount($remoteAccount);
                }
            }
        });

        return redirect()->action(ShowSettings::class);
    }

    private function importAccount(AccountTL $remoteAccount): void
    {
        $account = Account::firstOrNew([
            'external_id' => $remoteAccount->account_id,
        ]);

        if ($account->exists) {
            return;
        }

        $balance = $this->trueLayerClient->fetchBalance($remoteAccount->account_id);

        $account->fill([
            'account_provider_id' => $this->trueLayerClient->getProviderId(),
            'name'                => $remoteAccount->display_name,
            'account_number'      => $remoteAccount->account_number->iban,
            'currency'            => $remoteAccount->currency,
            'balance'             => $balance->current,
            'balance_updated_at'  => $balance->update_timestamp ?? now(),
        ]);

        Assertion::true($account->save());
    }
}
