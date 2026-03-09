<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $fillable=['name', 'CID'];

    static function dropdown(){
        $list='';
        $result=Self::all();
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
    public function countr(){
        return $this->belongsTo(Country::class,'CID','id');
    }
}
