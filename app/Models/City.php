<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable=['name', 'DSID','PID','CID'];

    static function dropdown($id=0){
        $list='';
        $result=Self::all();
        foreach ($result as $item){
            $list.='<option '.(($id==$item->id)?'selected':'').' value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
    //saudi arabia cities list
    public static function ksa_cityList($id=0){
        $list='';
        $result=self::where('CID',191)->get();
        foreach ($result as $item){
            $list.='<option '.($id==$item->id ?'selected':'').'  value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }

    public function province(){
        return $this->belongsTo(Province::class,'PID', 'id');
    }
    public function country(){
        return $this->belongsTo(Country::class,'CID','id');
    }
}
