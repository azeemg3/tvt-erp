<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    protected $fillable=['SID', 'refund_to', 'refund_type', 'pax_name', 'inv_date',
        'refund_date', 'source', 'airline', 'sector', 'refund_sector', 'ticket_no',
        'refund_amount', 'service_charges', 'vendor_charges', 'net_refund', 'payable',
        'refund_taxes', 'vendor_id', 'client_id',
        'remarks', 'trans_code', 'com_rec', 'com_paid', 'wh_air', 'pst_paid', 'psf',
        'discount', 'wh_client', 'agent_amount', 'agent_id', 'status',
        'currency', 'currency_rate',
        'rec_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'leadId'];
}
