<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable=['name', 'CID', 'PID', 'CTID'];

    public function city(){
        return $this->belongsTo(City::class,'CTID','id');
    }
    static function dropdown(){
        $list='';
        $result=Self::all();
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
}
