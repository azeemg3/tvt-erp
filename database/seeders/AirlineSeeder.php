<?php

namespace Database\Seeders;

use App\Models\Airline;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AirlineSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $airlines = [
            ['name' => 'PIA', 'iata_code' => 'PK', 'icao_code' => 'PIA', 'numeric_code' => '214', 'country' => 'Pakistan'],
            ['name' => 'Air Blue', 'iata_code' => 'PA', 'icao_code' => 'ABQ', 'numeric_code' => '615', 'country' => 'Pakistan'],
            ['name' => 'Sareen Air', 'iata_code' => 'ER', 'icao_code' => 'SEP', 'numeric_code' => '817', 'country' => 'Pakistan'],
        ];

        foreach ($airlines as $airline) {
            Airline::firstOrCreate(
                ['name' => $airline['name']],
                $airline + ['status' => 1, 'created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
