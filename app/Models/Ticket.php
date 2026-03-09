<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable=['SID', 'passport', 'pax_name', 'mobile', 'pax_type', 'source', 
        'airline', 'sector', 'route', 'departure_date', 'return_date', 'pnr', 'ticket_no', 
        'basic_fare', 'taxes', 'receiveable', 'currency', 'currency_rate', 'payable_id', 
        'flight_no', 'class', 'ticket_type', 'sp_yi_tax', 'rg_cvt_tax', 'yq_tax', 'ced_tax', 
        'pb_adv_tax', 'xz_tax', 'yd_tax', 'xt_ur_tax', 'other_taxes', 'total_taxes', 
        'com_rec', 'com_paid', 'wh_air', 'pst_paid', 'psf', 'discount', 'wh_client', 
        'fare_inc', 'taxes_inc', 'agent_amount', 'agent_id', 'payable',
        'profit', 'fourtnite_date','trans_code'];
}
