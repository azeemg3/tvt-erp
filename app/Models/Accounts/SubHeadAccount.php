<?php

namespace App\Models\Accounts;
use App\Models\Accounts\HeadAccount;
use App\Models\Accounts\RootAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubHeadAccount extends Model
{
    use HasFactory;
    protected $fillable=['name', 'HID'];

    public static function dropdown(){
        $list='';
        $res=self::all();
        foreach ($res as $re) {
            $list.='<option value="'.$re->id.'">'.$re->name.'</option>';
        }
        return $list;
    }
    public function head_acc(){
        return $this->hasManyThrough(HeadAccount::class,RootAccount::class, 'id', 'RID','HID','id');
    }
}
