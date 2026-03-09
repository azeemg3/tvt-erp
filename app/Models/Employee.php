<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable=['gender', 'DID','DPID', 'first_name', 'last_name', 'dob', 'cnic', 'martial_status',
        'emp_status', 'home_phone', 'mobile_phone', 'work_email', 'private_email', 'address', 'CID', 'CTID', 'joining_date', 'confirmation_date', 'terminate_date', 
        'basic_salary', 'allownces', 'net_salary', 'BID', 'created_by', 'updated_by', 'UID'];

    public function designation(){
        return $this->belongsTo(Designation::class, 'DID','id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    //@employee dropdown list
    public static function dropdown(){
        $list='';
        $result=self::all();
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'">'.$item->first_name.' '.$item->last_name.'</option>';
        }
        return $list;
    }
}
