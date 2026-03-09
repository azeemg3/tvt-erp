<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptVoucher extends Model
{
    use HasFactory;
    protected $fillable=['trans_date', 'posting_date', 'payment_to', 'payment_from',
        'payment_type', 'amount', 'cheque', 'currency', 'conversion_rate', 'ref', 'remarks',
        'status', 'Created_by', 'Updated_by', 'BID','trans_code','attach_file'];

    public function trans(){
        return $this->belongsTo(Transaction::class,'trans_code','trans_code');
    }
}
