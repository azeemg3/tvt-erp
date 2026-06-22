<?php

namespace App\Models\Accounts;
use App\Models\Accounts\HeadAccount;
use App\Models\Accounts\RootAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubHeadAccount extends Model
{
    use HasFactory;
    protected $fillable=['name', 'HID', 'code'];

    public function head(){
        return $this->belongsTo(HeadAccount::class, 'HID', 'id');
    }

    public static function dropdown(){
        $list='';
        $res=self::all();
        foreach ($res as $re) {
            $label = ($re->code ? $re->code.' - ' : '').$re->name;
            $list.='<option value="'.$re->id.'">'.$label.'</option>';
        }
        return $list;
    }
    public function head_acc(){
        return $this->hasManyThrough(HeadAccount::class,RootAccount::class, 'id', 'RID','HID','id');
    }
}
