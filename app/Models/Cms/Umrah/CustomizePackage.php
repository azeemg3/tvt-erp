<?php

namespace App\Models\Cms\Umrah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizePackage extends Model
{
    use HasFactory;
    protected $fillable=['pkg_name', 'price', 'makkah_hotel', 'madina_hotel', 'duraion',
        'makkah_night', 'madina_night', 'traveling_df','traveling_dt', 'pkg_details', 'created_by',
        'updated_by', 'BID','hotel_images', 'country_id','city_id','pkg_images','brochure_image'];
}
