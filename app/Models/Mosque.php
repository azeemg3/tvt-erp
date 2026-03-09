<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    use HasFactory;
    protected $fillable=['name', 'ARID'];

    public function area(){
        return $this->belongsTo(Area::class,'ARID','id');
    }
    public static function dropdown($id=0){
        $list='';
        $result=Self::all();
        foreach ($result as $item){
            $list.='<option '.(($id==$item->id)?'selected':'').' value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
}
