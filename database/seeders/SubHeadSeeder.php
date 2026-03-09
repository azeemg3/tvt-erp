<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accounts\SubHeadAccount;

class SubHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubHeadAccount::create([ 'name' => 'Petty Cash & Banks', 'HID' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Customer/Receivables', 'HID' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Security & Deposits', 'HID' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Advances', 'HID' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Fixed Assets', 'HID' => 2, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Employee', 'HID' => 1, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Credit Cards', 'HID' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Long Term Liabilities', 'HID' => 4, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Payable & Vendors', 'HID' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Short Term Loans', 'HID' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Short Term Liabilities', 'HID' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Third Party Agents', 'HID' => 3, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Sole Proprietor', 'HID' => 6, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Partenship', 'HID' => 6, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Retained Earnings', 'HID' => 6, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Unappropriated Profit', 'HID' => 6, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Incomes', 'HID' => 7, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Operating Expenses', 'HID' => 9, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Financial Expenses', 'HID' => 10, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
        SubHeadAccount::create([ 'name' => 'Cost Of Revenue', 'HID' => 11, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), ]);
    }
}
