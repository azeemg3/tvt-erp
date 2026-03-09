<?php

namespace App\Models\Bookings;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPax extends Model
{
    use HasFactory;
    protected $fillable=['title', 'pax_name', 'father_name', 'middle_name', 'last_name', 
        'gender', 'pax_type', 'dob', 'age', 'cnic', 'nationality', 'address',
        'passport_type', 'passport', 'passport_country', 'passport_issue_date',
        'passport_expire_date', 'tour_id', 'tour_type', 'created_by', 'updated_by'];

    public function country(){
        return $this->belongsTo(Country::class,'nationality','id');
    }
}
