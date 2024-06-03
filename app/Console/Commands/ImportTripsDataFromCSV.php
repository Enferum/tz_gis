<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Csv\Exception;
use League\Csv\Reader;

class ImportTripsDataFromCSV extends Command
{
    protected $name = 'import:trips_data_from_csv';

    /**
     * @throws Exception
     */
    public function handle()
    {
        $csvFile = fopen(storage_path('app/public/trips.csv'), 'r');
        $reader = Reader::createFromStream($csvFile);
        $reader->setHeaderOffset(0);

        DB::table('trips')->truncate();
        foreach ($reader->getRecords() as $record) {
            DB::table('trips')->insert([
                'id' => $record['id'],
                'driver_id' => $record['driver_id'],
                'pickup' => $record['pickup'],
                'dropoff' => $record['dropoff'],
            ]);
        }

        $this->info('Completed');
    }
}
