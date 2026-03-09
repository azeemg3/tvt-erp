<?php

namespace App\Models\Umrah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportBrnSector extends Model
{
    use HasFactory;
    protected $fillable=['from_city', 'to_city', 'sector_date', 'sector_time', 'TRBID'];
}
