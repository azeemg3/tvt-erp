<?php

namespace App\Models\Lms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherSale extends Model
{
    use HasFactory;

    protected $fillable=['SID', 'passport', 'pax_name', 'mobile', 'pax_type', 'group_no',
        'pkg_details', 'rate', 'payable_id', 'receiveable_id', 'psf', 'agent_amount', 'agent_id',
        'discount', 'pst', 'payable', 'receiveable', 'currency', 'currency_rate', 'created_by',
        'updated_by','trans_code', 'profit'];
}
