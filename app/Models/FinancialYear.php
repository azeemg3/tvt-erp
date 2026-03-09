<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    use HasFactory;
    protected $fillable=['id', 'start_year', 'end_year', 'created_at', 'updated_at'];
    public static function dropdown($id=0){
        $list='';
        $result=self::orderBy('id','DESC')->get();
        foreach ($result as $item){
            $list.='<option value="'.$item->start_year.'/' .$item->end_year.'">
            '.Carbon::createFromFormat('Y-m-d', $item->start_year)->year.'-'
                .Carbon::createFromFormat('Y-m-d', $item->end_year)->year.'
            </option>';
        }
        return $list;
    }
    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:i:s',
        'updated_at' => 'datetime:d-m-Y h:i:s',
    ];
}
