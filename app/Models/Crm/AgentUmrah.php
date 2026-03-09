<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentUmrah extends Model
{
    use HasFactory;
    protected $fillable=['flight', 'pnr', 'arr_flight', 'arr_dep_date', 'arr_dep_time', 
        'arr_date', 'arr_time', 'arr_sector', 'arr_terminal', 'dep_flight', 'dep_date', 
        'dep_dime', 'duration', 'dep_sector', 'dep_terminal', 'ground_handle_product', 
        'ground_price', 'created_by', 'updated_by', 'approved_time','remarks','remarks',
        'other_ground_information','draft','group_no', 'group_name','dep_arr_date',
        'dep_arr_time','trip_includes','conversion_rate','currency'];
}
