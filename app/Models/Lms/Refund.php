<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    protected $fillable=['SID', 'refund_to', 'refund_type', 'pax_name', 'inv_date',
        'refund_date', 'source', 'airline', 'sector', 'refund_sector', 'ticket_no',
        'refund_amount', 'service_charges', 'refund_taxes', 'vendor_id', 'client_id',
        'remarks', 'trans_code', 'com_rec', 'wh_air', 'psf', 'discount',
        'rec_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'leadId'];
}
