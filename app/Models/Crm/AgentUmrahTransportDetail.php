<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentUmrahTransportDetail extends Model
{
    use HasFactory;
    protected $fillable=['transport_date', 'transport_time', 'from_city', 'to_city', 
        'transport_type', 'no_pax', 'vehicle', 'rate', 'net_rate', 'UID'];
}
