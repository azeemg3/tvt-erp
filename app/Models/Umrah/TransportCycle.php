<?php

namespace App\Models\Umrah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportCycle extends Model
{
    use HasFactory;
    protected $fillable=['route_type', 'route', 'created_by',
        'updated_by', 'created_at', 'updated_at'];

    public static function dropdown(){
        $list='';
        $result=self::all();
        foreach ($result as $item) {
            $list.='<option value="'.$item->id.'">'.$item->route.'</option>';
        }
        return $list;
    }
}
