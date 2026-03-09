<?php

namespace App\Models\Bookings;

use App\Models\Tours\IntTour;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourBooking extends Model
{
    use HasFactory;

    public function tour_pkg(){
        return $this->belongsTo(IntTour::class,'pkg_id','id');
    }
}
