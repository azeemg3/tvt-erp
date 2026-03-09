<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    public static function hotelList(){
        $list='';
        $result=self::all();
        foreach ($result as $item){
            $list.='<option  value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
}
