<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroundHandleRate extends Model
{
    use HasFactory;

    public static function dropdown($id=0){
        $list='';
        $res=self::all();
        foreach ($res as $re){
            $list.='<option '.($id==$re->id?'selected':'').' value="'.$re->id.'">'.$re->comp_name.'</option>';
        }
        return $list;
    }
}
