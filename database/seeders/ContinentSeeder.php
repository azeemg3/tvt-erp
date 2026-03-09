<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Continents;
class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Continents::create([
            "name"=> "Africa", "code"=> "AF",
            'created_at' => \Carbon\Carbon::now(),

        ]);
        Continents::create([
            "name"=> "North America", "code"=> "NA",
            'created_at' => \Carbon\Carbon::now(),

        ]);
        Continents::create([
            "name"=> "Oceania", "code"=> "OC",
            'created_at' => \Carbon\Carbon::now(),

        ]);
        Continents::create([
            "name"=> "Antarctica", "code"=> "AN",
            'created_at' => \Carbon\Carbon::now(),

        ]);
        Continents::create([
            "name"=> "Asia", "code"=> "AS",
            'created_at' => \Carbon\Carbon::now(),

        ]);
        Continents::create([
            "name"=> "Europe", "code"=> "EU",
            'created_at' => \Carbon\Carbon::now(),

        ]);
        Continents::create([
            "name"=> "South America", "code"=> "SA",
            'created_at' => \Carbon\Carbon::now(),

        ]);
    }
}
