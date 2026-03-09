<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    protected $fillable=['name','no_beds'];

    public static function dropdown($id=0){
        $res=self::all();
        $list='';
        foreach ($res as $re){
            $list.='<option '.($id==$re->id?'selected':'').' value="'.$re->id.'" data-beds="'.$re->no_beds.'">'.$re->name.'</option>';
        }
        return $list;
    }
}
