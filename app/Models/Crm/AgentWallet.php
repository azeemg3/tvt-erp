<?php

namespace App\Models\Crm;

use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class AgentWallet extends Model
{
    use HasFactory;
    public function agent(){
        return $this->belongsTo(\App\Models\Agent::class, 'agentID', 'id');
    }
    //payment from
    public function pf(){
        return $this->belongsTo(TransactionAccount::class,'payment_from','id');
    }
    public static function agent_balance(){
        $id=Agent::where('UID', Auth::user()->id)->value('id');
        $balance=AgentWallet::where('agentID', $id)->sum('amount');
        $use_amount=DB::table('agent_payment_vouchers AS p')->where('agentID', $id)
        ->select(DB::raw('sum(p.amount) AS amount'))->value('amount');
        $net=($balance)-($use_amount);
        if($balance!=Null){
            return $net;
        }
        return $balance='0.00';
    }
}
