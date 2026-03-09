<?php

namespace App\Models\Umrah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportCompany extends Model
{
    use HasFactory;
    protected $fillable=['name','created_by','updated_by'];

    public static function dropdown($id=0){
        $list='';
        $result=self::all();
        foreach ($result as $item){
            $list.='<option '.($id==$item->id?'selected':'').' value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
}
