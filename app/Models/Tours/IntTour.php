<?php

namespace App\Models\Tours;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntTour extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['pkg_name', 'country_id', 'starting_price', 'duration', 'validity_from', 'validity_to', 'departure_details',
        'pkg_images', 'explore_details', 'your_info', 'adult_visa_price', 'child_visa_price', 'infant_visa_price', 'visa_vendor',
        'transports', 'hotels', 'term_conditions', 'gs_vendor', 'gs_rate', 'markup', 'created_by', 'updated_by', 'created_at',
        'updated_at','highlights'];

    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');
    }
}
