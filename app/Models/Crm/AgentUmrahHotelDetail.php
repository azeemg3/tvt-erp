<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentUmrahHotelDetail extends Model
{
    use HasFactory;
    protected $fillable=['city', 'hotel_id', 'room_type', 'room', 'no_pax', 'checkin', 'nights', 
        'checkout', 'rate', 'net_rate', 'UID'];
}
