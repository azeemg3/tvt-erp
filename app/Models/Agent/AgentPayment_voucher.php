<?php

namespace App\Models\Agent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentPayment_voucher extends Model
{
    use HasFactory;
    protected $fillable=['transaction_date', 'agentID', 'narration', 'amount',
        'trans_code', 'created_by','invID'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:i:s',
        'updated_at' => 'datetime:d-m-Y h:i:s',
    ];
}
