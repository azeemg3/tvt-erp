<?php

namespace App\Models;

use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaRate extends Model
{
    use HasFactory;
    protected $fillable=['visa_type', 'product_name', 'source', 'currency_id', 'currency_rate',
        'adult_det', 'child_det','infant_det', 'created_by', 'updated_by',
        'validity_from', 'validity_to','status'];

    public function source(){
        return $this->belongsTo(TransactionAccount::class,'source','id');
    }
}
