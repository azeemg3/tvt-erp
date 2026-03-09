<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;
    protected $fillable=['SID', 'passport', 'pax_name', 'mobile', 'pax_type', 'rate', 
        'payable_id', 'vehicle_type', 'from_date', 'to_date', 'receiveable_id', 'psf', 
        'f_agent', 's_agent', 'discount', 'pst', 'payable', 'receiveable', 'currency', 
        'currency_rate', 'created_by', 'updated_by','trans_code','profit'];
}
