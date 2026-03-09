<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $fillable=['id', 'leadId', 'transaction_date', 'posting_date', 'branch',
        'payment_type', 'payment_to', 'payment_from', 'particulars', 'SID', 'amount',
        'balance', 'cheque_no', 'currency', 'currency_rate', 'status', 'created_at',
        'updated_at', 'created_by','updated_by'];
}
