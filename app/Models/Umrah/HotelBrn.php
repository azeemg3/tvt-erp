<?php

namespace App\Models\Umrah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class HotelBrn extends Model
{
    use HasFactory;
    protected $fillable=['HTBRN', 'no_pax', 'GRID'];

    public static function group_hotel_brn($gid=0, $brn=0){
        $list='';
        $result=DB::table('hotel_brns')->join('hotel_reservation_brns','hotel_brns.HTBRN','hotel_reservation_brns.id')
            ->where('hotel_brns.GRID', $gid)->get();
        foreach ($result as $item){
            $list.='<option '.(($item->brn==$brn)?'selected':'').' value="'.$item->brn.'" val-hotel="'.$item->hotel_id.'"
             purchase-rate="'.$item->purchase_rate.'" qty="'.$item->no_pax.'">'.$item->brn.'</option>';
        }
        return $list;
    }
}
