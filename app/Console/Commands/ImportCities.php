<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use DB;

class ImportCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cities {--province=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports cities/municipalities and their barangays.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $province = $this->option('province');

        $province_id = DB::table('provinces')
                    ->where('name', $province)
                    ->value('id');

        if (!$province_id) {
            echo "Province does not exist. Creating now..\n";
            $province_id = DB::table('provinces')->insertGetId(['name' => $province]);
        }


        foreach (Storage::allFiles('csv/cities/' . $province) as $city_path) {
            $city_name = str_replace('.csv', '', ucwords(basename($city_path)));

            $city_id = DB::table('cities')
                ->where('name', $city_name)
                ->value('id');

            if (!$city_id) {
                echo "City does not exist. Creating now..\n";
                $city_id = DB::table('cities')->insertGetId(['name' => $city_name, 'province_id' => $province_id]);
            }

            $handle = fopen(storage_path('app/' . $city_path), "r");

            $barangay_count = DB::table('barangays')
                ->where('city_id', $city_id)
                ->count();

            if ($barangay_count === 0) {
                $count = 0;
                echo "Now importing barangays for {$city_name}..\n";
                while ($line = fgetcsv($handle, 1000, ",")) {
                    DB::table('barangays')->insert([
                        'city_id' => $city_id,
                        'name' => $line[0]
                    ]);

                    echo $line[0] . "\n";
                    $count += 1;
                }
                echo "Done importing {$count} barangays for {$city_name}.\n";
            } else {
                echo "There are already existing barangays for {$city_name}.\n";
            }
        }
    }
}
