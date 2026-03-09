<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $fillable=['name', 'PID'];

    public function province(){
        return $this->belongsTo(Province::class,'PID', 'id');
    }

    public static function dropdown(){
        $list='';
        $result=Self::all();
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
}
