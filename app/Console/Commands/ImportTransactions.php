<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\CounterParty;
use App\Models\Month;
use App\Models\Transaction;
use App\TrueLayer\TransactionMeta;
use App\TrueLayer\TransactionTL;
use App\TrueLayer\TrueLayerClient;
use Illuminate\Console\Command;

class ImportTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports any new transactions from the TrueLayer API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TrueLayerClient $client)
    {


        \DB::transaction(function () use ($client) {
            $account           = Account::first();
            $lastTransactionAt = Transaction::orderBy('transaction_at', 'desc')
                                            ->first()->transaction_at;

            if ($lastTransactionAt === null) {
                $lastTransactionAt = today()->subDays(90);
            }

            $this->output->writeln("Fetching all transactions since $lastTransactionAt");

            $transactions = $client->fetchTransactions($account->external_id, $lastTransactionAt, now());

            $this->withProgressBar($transactions, function (TransactionTL $transaction) {
                $this->importTransaction($transaction);
            });
        });

        return Command::SUCCESS;
    }

    private function importTransaction(TransactionTL $transaction): void
    {
        if (Transaction::whereExternalId($transaction->transaction_id)
                       ->exists()) {
            return;
        }

        $counterParty = $this->findCounterParty($transaction->meta);

        Transaction::create([
                                'external_id'      => $transaction->transaction_id,
                                'account_id'       => Account::first()
                                                             ->getKey(),
                                'category_id'      => $counterParty?->default_category_id,
                                'counter_party_id' => $counterParty?->getKey(),
                                'transaction_at'   => $transaction->timestamp,
                                'description'      => $transaction->description,
                                'amount'           => $transaction->amount,
                                'currency'         => $transaction->currency,
                            ]);
    }

    private function findCounterParty(TransactionMeta $transactionMeta): ?CounterParty
    {
        if (! $transactionMeta->counter_party_preferred_iban) {
            if (! $transactionMeta->counter_party_preferred_name) {
                return null;
            }

            return CounterParty::firstOrCreate([
                                                   'name' => $transactionMeta->counter_party_preferred_name,
                                               ]);
        }

        $counterParty = CounterParty::firstOrNew([
                                                     'iban' => $transactionMeta->counter_party_preferred_iban,
                                                 ]);

        if (! $counterParty->exists) {
            $counterParty->name = $transactionMeta->counter_party_preferred_name;
            $counterParty->save();
        }

        return $counterParty;
    }
}
