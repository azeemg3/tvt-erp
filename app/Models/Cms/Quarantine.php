<?php

namespace App\Models\Cms;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarantine extends Model
{
    use HasFactory;
    protected $fillable=['pkg_name', 'country_id', 'city_id', 'airline_id', 'inclusions', 'guest_price',
        'pkg_details', 'quarantine_information', 'hotel_name', 'checkin_date', 'checkin_time',
        'checkout_date', 'checkout_time', 'hotel_star', 'hotel_images', 'transport_type',
        'transport_city', 'transport_date', 'transport_image', 'BID', 'creatd_by', 'updated_by'];
    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
    }
}
