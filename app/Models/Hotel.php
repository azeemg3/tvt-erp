<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable=['name','country','address', 'city'];

    public static function dropdown($id=0){
        $list='';
        $result=Self::all();
        foreach ($result as $item){
            $list.='<option '.(($id==$item->id)?'selected':'').' value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
    /*
     * Assign hotel to agent which are assign for umrah vouchers
     */
    public static function agentHotel($agentID=0, $city=0){
        $result=DB::table('hotel_agent_prices')
            ->leftjoin('hotels','hotel_agent_prices.hotel_id', 'hotels.id')
            ->select("hotels.name","hotels.id AS hotel_id")
            ->where('hotel_agent_prices.agent',$agentID)->where('hotels.city',$city)
            ->groupBy('hotel_id')->get();
        $list='';
        foreach ($result as $item){
            $list.='<option value="'.$item->hotel_id.'">'.$item->name.'</option>';
        }
        return $list;
    }

    public function country(){
        return $this->belongsTo(Country::class,'country','id');
    }
}
