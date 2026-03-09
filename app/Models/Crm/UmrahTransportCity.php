<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmrahTransportCity extends Model
{
    use HasFactory;
    public static function dropdown($id=0){
        $list='';
        $res=self::all();
        foreach ($res as $item){
            $list.='<option '.($id==$item->id?'selected':'').' value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
}
