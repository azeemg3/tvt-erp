<?php

namespace App\Models\Crm;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentUmrahPaxDetail extends Model
{
    use HasFactory;
    protected $fillable=[ 'title', 'pax_name', 'group_leader', 'father_name', 'middle_name',
        'last_name', 'gender', 'pax_type', 'dob', 'cnic', 'nationality', 'address', 'visa_rate',
        'passport_type', 'passport', 'passport_country', 'passport_issue_date',
        'passport_expire_date', 'UID','group_id','mofa'];

    public function country(){
        return $this->belongsTo(Country::class, 'nationality','id');
    }
}
