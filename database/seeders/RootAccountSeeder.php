<?php

namespace Database\Seeders;
use App\Models\Accounts\RootAccount;

use Illuminate\Database\Seeder;

class RootAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RootAccount::create([
            'name' => 'Asset',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        RootAccount::create([
            'name' => 'Liability',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        RootAccount::create([
            'name' => 'Owner Equity',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        RootAccount::create([
            'name' => 'Income',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        RootAccount::create([
            'name' => 'Expense',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
