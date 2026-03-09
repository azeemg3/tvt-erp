<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accounts\TransactionAccount;

class TransAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Void Income', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'INCENTIVE INCOME', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Visa Refund Service Charges', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Ticket Commission Revenue', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Transfer Refund Service Charges', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Hotel Refund Service Charges', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Ticket Taxes Increase INC', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Ticket Fare Increase INC', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Psf', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Transfer Income', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Cancellation Charges', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Ticket Refund Services Charges', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Other Income', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Tour Income', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Hotel Commission Revenue', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Visa Income', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Hotel Income', 'PID' => 17, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Agent Commission Expense', 'PID' => 20, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Discount Allowed', 'PID' => 20, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Hotel Commission Paid', 'PID' => 20, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Ticket Commission Paid', 'PID' => 20, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'PST', 'PID' => 10, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'WH Tax', 'PID' => 4, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
        TransactionAccount::create([ 'Trans_Acc_Name' => 'Unappropriated Profit', 'PID' => 16, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'editable' => 0, ]);
    }
}
