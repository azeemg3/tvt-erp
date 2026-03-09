<?php

namespace App\Models\Umrah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupVoucher extends Model
{
    use HasFactory;
    protected $fillable=['voucher', 'total_amount', 'status', 'GID','currency',
        'currenty_rate','trans_code'];
}
