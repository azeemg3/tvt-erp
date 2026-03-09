<?php

namespace App\Models\Agent;

use App\Models\Accounts\Agent;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentWallet extends Model
{
    use HasFactory;
    protected $fillable=[ 'trans_date', 'posting_date', 'payment_from', 'agentID',
        'narration', 'amount', 'created_by', 'updated_by', 'created_at','trans_code'];

    public function agent(){
        return $this->belongsTo(Agent::class, 'agentID', 'id');
    }
    //payment from
    public function pf(){
        return $this->belongsTo(TransactionAccount::class,'payment_from','id');
    }
}
