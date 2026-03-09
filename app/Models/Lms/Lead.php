<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable=['contact_name', 'code', 'mobile', 'email', 'cnic', 'spo', 
        'travel_date_from', 'travel_date_to', 'CID', 'CTID', 'services', 'sector', 
        'source_of_query', 'other_details', 'status', 'created_by', 'current_lead_owner', 
        'close_status', 'BID'];

    //change lead status when sale mature
    public static function change_lead_status($id, $status){
        return self::where(['id'=>$id])->update(['status'=>$status]);
    }

    public static function LeadCustomer(){
        $list='';
        $result=Lead::all();
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'">'.$item->contact_name.'</option>';
        }
        return $list;
    }
}
