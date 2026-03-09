<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable=['id', 'name'];
    static function dropdown($id=0){
        $list='';
        $result=Self::all();
        foreach ($result as $item){
            $list.='<option '.(($item->id==$id)?'selected':'').' value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }

}
