<?php

namespace App\Console\Commands;

use App\Models\Month;
use Carbon\Carbon;
use Doctrine\DBAL\DriverManager;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private const TABLES = [
        'category_groups' => [],
        'categories'      => [],
        'counter_parties' => [],
        'transactions'    => [],
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sourceDbal = DriverManager::getConnection([
                                                       'username' => 'budget',
                                                       'dbname'   => 'budget',
                                                       'password' => 'budgeteer',
                                                       'driver'   => 'pdo_pgsql',
                                                   ]);

        $schema = \DB::getDoctrineSchemaManager();

        $timestamps = [
            'created_at' => now(),
            'updated_at' => now(),
        ];

        foreach (self::TABLES as $tableName => $_) {
            $table       = \DB::table($tableName);
            $columns     = $schema->listTableColumns($tableName);
            $columnNames = array_keys($columns);

            $this->output->writeln($tableName);

            foreach ($sourceDbal->executeQuery("SELECT * FROM $tableName")
                                ->iterateAssociative() as $row) {
                if (isset($row['period_id'])) {
                    $row['period_id'] = $this->findTransactionPeriod($row);
                    $row['amount']    *= 100;
                }
                $table->insert(Arr::only(array_merge($timestamps, $row), $columnNames));
            }
        }

        return Command::SUCCESS;
    }

    private function findTransactionPeriod(array $row): int
    {
        $carbon = Carbon::parse($row['transaction_at']);

        return Month::findOrCreateForDate($carbon)
                    ->getKey();
    }
}
