<?php

namespace App\Models\Lms;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadHotel extends Model
{
    use HasFactory;
    protected $fillable=['SID', 'passport', 'pax_name', 'mobile', 'pax_type', 'group_no',
        'hotel', 'checkin', 'checkout', 'nights', 'room_no', 'payable_id', 'receiveable_id',
        'confirmation', 'int_ref', 'guest_beds', 'meal', 'rate_night', 'amount', 'com_rec',
        'com_paid', 'wh_air', 'pst_paid', 'psf', 'agent_amount', 'agent_id', 'discount', 'pst',
        'payable', 'receiveable', 'currency', 'currency_rate', 'created_by', 'updated_by',
        'created_at', 'updated_at', 'room_type', 'trans_code','profit'];

    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel','id');
    }
    public function hotels(){
        return $this->belongsTo(Hotel::class,'hotel','id');
    }
}
