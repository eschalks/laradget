<?php

namespace App\Console\Commands;

use App\Models\Month;
use Assert\Assertion;
use Carbon\Carbon;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Illuminate\Console\Command;

class ImportSqliteDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sqlite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

//    private const TABLES = [
//        'periods',
//        'category_groups',
//        'categories',
//        'counter_parties',
//        'transactions',
//    ];
    private \Doctrine\DBAL\Connection $sourceDbal;

    /**
     * @var \Doctrine\DBAL\Schema\AbstractSchemaManager
     */
    private AbstractSchemaManager $schema;

    /**
     * Exec
     * ute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->sourceDbal = DriverManager::getConnection([
//                                                       'url' => 'sqlite:///'.base_path('database.periods.bak.sqlite'),
'url'    => 'sqlite:///'.database_path('database.sqlite'),
'driver' => 'pdo_sqlite',
                                                         ]);

        $this->schema = \DB::getDoctrineSchemaManager();

        \DB::transaction(function () {
            $tablesToImport = $this->schema->listTableNames();
            if (!$tablesToImport) {
                throw new \Exception('Database was not found: '.database_path('database.sqlite'));
            }
            while ($tablesToImport) {
                $tableName = array_shift($tablesToImport);
                if (! $this->importTable($tableName, $tablesToImport)) {
                    $tablesToImport[] = $tableName;
                }
            }
        });

        return Command::SUCCESS;
    }

    private function findTransactionPeriod(array $row): int
    {
        $carbon = Carbon::parse($row['transaction_at']);

        return Month::findOrCreateForDate($carbon)
                    ->getKey();
    }

    private function importTable(string $tableName, array $tablesToImport): bool
    {
        if ($tableName === 'migrations') {
            return true;
        }

        $this->output->writeln($tableName);
        $foreignKeys = $this->schema->listTableForeignKeys($tableName);

        foreach ($foreignKeys as $foreignKey) {
            if (in_array($foreignKey->getForeignTableName(), $tablesToImport, true)) {
                $this->output->writeln('Skipped due to FK for '.$foreignKey->getForeignTableName());

                return false;
            }
        }

        $targetTable = \DB::table($tableName);
//        $columnNames = array_keys($columns);

//        $sourceTable = $tableName === 'months' ? 'periods' : $tableName;
        foreach ($this->sourceDbal->executeQuery("SELECT * FROM $tableName")
                                  ->iterateAssociative() as $row) {

//
//            if (isset($row['period_id'])) {
//                $row['month_id'] = $row['period_id'];
//                unset($row['period_id']);
//            }

            $row = $this->convertRow($row);

            $targetTable->insert($row);
        }

        return true;
    }

    private function convertRow(array $row): array
    {
        dump($row);

        foreach ($row as $field => $value) {
            if ($field === 'amount' || $field === 'balance') {
                $decimal = $this->convertToDecimal($value);
                Assertion::same((int) str_replace('.', '', $decimal), $value);

                $row[$field] = $decimal;
            }

            if (str_ends_with($field, '_at') && is_int($value)) {
                $row[$field] = $this->convertDateTime($value);
            }
        }

        return $row;
    }

    private function convertToDecimal(int $amount): string
    {
        $cents = (string) abs($amount % 100);
        $euros = (string) abs(intdiv($amount, 100));

        $cents = \Str::padLeft($cents, 2, '0');

        $prefix = $amount < 0 ? '-' : '';

        return "$prefix$euros.$cents";
    }

    private function convertDateTime(int $value): \DateTimeInterface
    {
        return Carbon::createFromTimestampMsUTC($value);
    }
}
