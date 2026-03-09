<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportAgentPrice extends Model
{
    use HasFactory;
    protected $fillable=['agent', 'from_city', 'to_city', 'transport_type', 'month',
        'validity_date_rate', 'markup_type', 'markup_value', 'TRID'];
}
