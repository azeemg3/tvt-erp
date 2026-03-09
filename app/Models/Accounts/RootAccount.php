<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RootAccount extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    public static function dropdown(){
        $result=self::all();
        $list='';
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'">'.$item->name.'</option>';
        }
        return $list;
    }
}
