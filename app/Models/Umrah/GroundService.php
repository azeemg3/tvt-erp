<?php

namespace App\Models\Umrah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroundService extends Model
{
    use HasFactory;
    protected $fillable=['ground_services_type', 'company_name', 'license_no',
        'contact_person', 'contact_number', 'contact_email', 'web_address', 'start_date',
        'end_date', 'repersentative_contact', 'ground_services_address',
        'service_contact_person', 'external_agent', 'service_license_no',
        'umrah_company', 'adult_rate', 'child_rate', 'infant_rate', 'insurance_adult_rate',
        'insurance_child_rate', 'insurance_infant_rate','insured_person',
        'insured_qty','created_by','updated_by','grand_total','adult_qty','child_qty','infant'];

    public static function dropdown(){
       $list='';
       $result=self::all();
       foreach ($result as $item){
           $list.='<option value="'.$item->id.'">'.$item->company_name.'</option>';
       }
       return $list;
    }
}
