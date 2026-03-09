<?php

namespace App\Models\Umrah;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentUmrahVisitor extends Model
{
    use HasFactory;
    protected $fillable=[ 'title', 'pax_name', 'group_leader', 'father_name', 'middle_name',
        'last_name', 'gender', 'pax_type', 'dob','age', 'cnic', 'nationality', 'address',
        'passport_type', 'passport', 'passport_country', 'passport_issue_date',
        'passport_expire_date', 'UID','group_id','mofa','visa','visa_attachment','code'];

    public function country(){
        return $this->belongsTo(Country::class, 'nationality','id');
    }
}
