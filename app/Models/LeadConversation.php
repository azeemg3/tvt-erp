<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadConversation extends Model
{
    use HasFactory;
    protected $fillable=['leadId', 'comment', 'reminder'];
}
