<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRateKsa extends Model
{
    use HasFactory;
    protected $fillable=['UID', 'ack_by', 'total_pax', 'total_room', 'rate',
        'total', 'remarks', 'source','confirmation_no','room_type'];
}
