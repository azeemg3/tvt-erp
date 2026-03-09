<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeadAccount extends Model
{
    use HasFactory;
    protected $fillable=['RID', 'name'];

    public function root(){
        return $this->belongsTo(RootAccount::class, 'RID', 'id');
    }
    public static function dropdown(){
        $list='';
        $res=self::all();
        foreach ($res as $re) {
            $list.='<option value="'.$re->id.'">'.$re->name.'</option>';
        }
        return $list;
    }
}
