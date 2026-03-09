<?php

namespace App\Models\Agent;

use App\Models\Accounts\Agent;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentCommission extends Model
{
    use HasFactory;
    protected $fillable=['id', 'product', 'validity_from', 'validity_to', 'SAID',
        'subadmin_commission','currency',
        'agent_commission', 'go_commission', 'created_by', 'updated_by','total_commission'];

    public function agent(){
        return $this->belongsTo(Agent::class,'SAID','id');
    }
    public function currency(){
        return $this->belongsTo(Currency::class,'currency','id');
    }
}
