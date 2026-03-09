<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmrahTransportCity extends Model
{
    use HasFactory;

    public static function dropdown($id=0){
        $list='';
        $res=self::all();
        foreach ($res as $item){
            $list.='<option '.(($id==$item->id)?'selected':'').' value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
    public static function cycle(){
        $list='';
        $res=self::all();
        foreach ($res as $item){
            $list.='<option value="'.$item->name.'">'.$item->name.'</option>';
        }
        return $list;
    }
    //transport city
    public static function get_city($id=0){
        return self::where('id', $id)->value('name');
    }
}
