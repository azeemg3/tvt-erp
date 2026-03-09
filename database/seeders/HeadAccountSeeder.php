<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accounts\HeadAccount;

class HeadAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HeadAccount::create([
            'name' => 'Current Assets',
            'RID' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        HeadAccount::create([
            'name' => 'Fixed Assets',
            'RID' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        //Liabilities
        HeadAccount::create([
            'name' => 'Current Liability',
            'RID' => 2,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        HeadAccount::create([
            'name' => 'Long Term Liabilities',
            'RID' => 2,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        //Capital
        HeadAccount::create([
            'name' => 'Shareholders\' Equity',
            'RID' => 3,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        HeadAccount::create([
            'name' => 'Capital',
            'RID' => 3,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        //Revenu income
        HeadAccount::create([
            'name' => 'Revenue',
            'RID' => 4,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        HeadAccount::create([
            'name' => 'Retained Earnings',
            'RID' => 4,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        //Expense
        HeadAccount::create([
            'name' => 'Operating Expenses',
            'RID' => 5,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        HeadAccount::create([
            'name' => 'Financial Expenses',
            'RID' => 5,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        HeadAccount::create([
            'name' => 'Cost Of Revenue',
            'RID' => 5,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

    }
}
