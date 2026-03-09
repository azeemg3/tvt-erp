<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelAgentPrice extends Model
{
    use HasFactory;
    protected $fillable=['agent', 'markup_type', 'markup_value', 'hotel_id',
        'room_type', 'month', 'validity_date_rate', 'HRID'];
}
