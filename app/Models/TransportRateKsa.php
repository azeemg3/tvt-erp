<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRateKsa extends Model
{
    use HasFactory;
    protected $fillable=['UID', 'ack_by', 'total_pax', 'total_vehicle',
        'rate', 'total', 'remarks','confirmation_no'];
}
