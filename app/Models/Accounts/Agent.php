<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $fillable=['agent_name', 'agent_mobile', 'agent_email', 'agent_country',
        'agent_city', 'agent_address', 'agent_other_details', 'PID', 'created_by',
        'updated_by','agentID','agent_type','status','agent_code','UID','agent_province',
        'ARID','mosqueID','seen'];


    public static function dropdown($id=0){
        $list='';
        $result=self::all();
        foreach ($result as $item){
            $list.='<option '.($id==$item->id?'selected':'').' value="'.$item->id.'">'.$item->agent_name.'</option>';
        }
        return $list;
    }
    public static function agent($id=0){
        $list='';
        $result=self::all();
        foreach ($result as $item){
            $list.='<option '.(($id==$item->id)?'selected':'').' value="'.$item->id.'">'.$item->agent_name.' ('.($item->agent_type==0?'Sub Admin':'Agent').')</option>';
        }
        return $list;
    }
    public static function subAgentList(){
        $list='';
        $result=self::where('agent_type',0)->get();
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'">'.$item->agent_name.'</option>';
        }
        return $list;
    }
    public function subagent(){
        return $this->belongsTo(self::class,'agentID','id');
    }


}
