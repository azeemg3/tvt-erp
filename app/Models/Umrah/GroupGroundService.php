<?php

namespace App\Models\Umrah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class GroupGroundService extends Model
{
    use HasFactory;
    protected $fillable=['service_id', 'no_pax', 'group_id'];
    //grond services linked dropdown
    public static function group_gs($gid=0, $service=''){
        $list='';
        $result=DB::table('group_ground_services')->join('ground_services',
            'group_ground_services.service_id','ground_services.id')
            ->where('group_id', $gid)->get();
        foreach ($result as $item){
            $list.='<option '.($item->id==$service?'selected':'').' value="'.$item->id.'" purchase-rate="'.$item->grand_total.'">'.$item->umrah_company.'</option>';
        }
        return $list;
    }
}
