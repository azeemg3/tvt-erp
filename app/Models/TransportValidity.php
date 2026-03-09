<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportValidity extends Model
{
    use HasFactory;
    protected $fillable=['validity_date','TRID', 'month', 'rate'];
}
