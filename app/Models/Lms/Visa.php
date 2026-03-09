<?php

namespace App\Models\Lms;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{
    use HasFactory;
    protected $fillable=['SID', 'passport', 'pax_name', 'mobile', 'pax_type', 'visa_type',
        'visa_no', 'group_no', 'visa_country', 'visa_rate', 'payable_id', 'receiveable_id',
        'amount', 'psf', 'f_agent', 's_agent', 'discount', 'pst', 'payable', 'receiveable',
        'currency', 'currency_rate', 'created_by', 'updated_by','trans_code','profit'];

    public function country(){
        return $this->belongsTo(Country::class,'visa_country','id');
    }
}
