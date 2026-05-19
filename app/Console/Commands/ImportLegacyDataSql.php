<?php

namespace App\Console\Commands;

use App\Support\LegacyDataSqlImporter;
use Illuminate\Console\Command;

class ImportLegacyDataSql extends Command
{
    protected $signature = 'legacy:import-data-sql
        {path=data.sql : Path to the legacy MySQL dump file}
        {--fresh : Clear imported marketplace tables before importing}';

    protected $description = 'Import legacy marketplace data from data.sql into the current Laravel schema.';

    public function handle(LegacyDataSqlImporter $importer): int
    {
        $path = (string) $this->argument('path');

        $resolvedPath = str_starts_with($path, DIRECTORY_SEPARATOR)
            ? $path
            : base_path($path);

        $summary = $importer->import($resolvedPath, (bool) $this->option('fresh'));

        $this->components->info('Legacy data import completed.');
        $this->newLine();
        $this->table(
            ['Users', 'Listings', 'Bookings', 'Saved listings'],
            [[
                $summary['users'],
                $summary['listings'],
                $summary['bookings'],
                $summary['saved_listings'],
            ]],
        );

        return self::SUCCESS;
    }
}
