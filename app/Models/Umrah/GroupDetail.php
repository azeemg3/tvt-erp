<?php

namespace App\Models\Umrah;

use App\Models\Country;
use App\Models\Crm\Agent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDetail extends Model
{
    use HasFactory;
    protected $fillable=['agentID', 'country', 'group_code', 'group_name', 'embassy',
        'voucherID', 'mofa_date', 'payment_date','created_by','updated_by','seen'];

    public function agent(){
        return $this->belongsTo(\App\Models\Accounts\Agent::class, 'agentID','id');
    }
    public function country(){
        return $this->belongsTo(Country::class,'country','id');
    }
    public function hotel_brn(){
        return $this->hasMany(HotelBrn::class,'GRID','id');
    }

    //@groups drop down
    public static function dropdown($id=0){
        $list='';
        $result=self::all();
        foreach ($result as $item) {
            $list.='<option '.($id==$item->id?'selected':'').' value="'.$item->id.'">'.$item->group_name.'-'.$item->group_code.'</option>';
        }
        return $list;
    }
}
