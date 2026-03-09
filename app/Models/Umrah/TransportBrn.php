<?php

namespace App\Models\Umrah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TransportBrn extends Model
{
    use HasFactory;
    protected $fillable=['TRBRN','no_pax','GRID'];

    public static function group_transport_brn($gid=0, $brn=0){
        $list='';
        $result=DB::table('transport_brns')->join('transport_reservation_brns',
            'transport_brns.TRBRN','transport_reservation_brns.id')
            ->where('transport_brns.GRID', $gid)->get();
        foreach ($result as $item){
            $list.='<option value="'.$item->brn.'" '.(($item->brn==$brn)?'selected':'').' trans-comp="'.$item->transport_co.'" 
            purchase-rate="'.$item->purchase_rate.'" qty="'.$item->no_pax.'">'.$item->brn.'</option>';
        }
        return $list;
    }
}
