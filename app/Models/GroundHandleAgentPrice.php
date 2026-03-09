<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroundHandleAgentPrice extends Model
{
    use HasFactory;
    protected $fillable=['rate_type', 'agents', 'markup_type', 'markup_value', 'GHID'];
}
