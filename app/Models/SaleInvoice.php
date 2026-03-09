<?php

namespace App\Models;

use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoice extends Model
{
    use HasFactory;
    protected $fillable=['leadId', 'type','inv_date', 'due_date', 'fourtnite', 'payment_type', 'remarks',
        'created_by', 'updated_by', 'BID', 'trans_code', 'created_at', 'updated_at', 
        'status', 'ledger'];

    public function ledgers(){
        return $this->belongsTo(TransactionAccount::class, 'ledger','id');
    }
}
