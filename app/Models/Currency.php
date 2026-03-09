<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable=['rate', 'currency_symbol', 'country','created_by','updated_by'];

    public function country(){
        return $this->belongsTo(Country::class, 'country','id');
    }
    public static function dropdown(){
        $list='';
        $result=Self::all();
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'">'.$item->currency_symbol.'</option>';
        }
        return $list;
    }

}
