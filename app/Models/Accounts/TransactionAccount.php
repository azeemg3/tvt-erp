<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionAccount extends Model
{
    use HasFactory;
    protected $fillable=['Trans_Acc_Name', 'PID', 'Parent_Type', 'OB', 'OB_Type',
        'BID', 'Created_BY', 'Updated_By', 'Last_Activity','code'];

    public function subhead(){
        return $this->belongsTo(SubHeadAccount::class,'PID', 'id');
    }
    public static function dropdown(){
        $list='';
        $res=self::all();
        foreach ($res as $re){
            $list.='<option value="'.$re->id.'">'.$re->Trans_Acc_Name.'</option>';
        }
        return $list;
    }
    //@vendor drop down
    public static function vendor_dd(){
        $list='';
        $res=self::where('PID', 9)->get();
        foreach ($res as $re){
            $list.='<option value="'.$re->id.'">'.$re->Trans_Acc_Name.'</option>';
        }
        return $list;
    }
    //@client drop down
    public static function client_dd(){
        $list='';
        $res=self::whereIn('PID', array(2,21))->get();
        foreach ($res as $re){
            $list.='<option value="'.$re->id.'">'.$re->Trans_Acc_Name.'</option>';
        }
        return $list;
    }
    //@bank and cash drop down list
    public static function bank_cash(){
        $list='';
        $res=self::where('PID', 1)->get();
        foreach ($res as $re){
            $list.='<option value="'.$re->id.'">'.$re->Trans_Acc_Name.'</option>';
        }
        return $list;
    }
}
