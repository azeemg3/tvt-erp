<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketSource;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketSource::create([
            'name' => 'Gallileo',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            ]);
        TicketSource::create([
            'name' => 'Amadeous',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            ]);
        TicketSource::create([
            'name' => 'Sabre',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            ]);
    }
}
