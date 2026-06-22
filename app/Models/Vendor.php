<?php

namespace App\Models;

use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'vendor_code',
        'account_id',
        'vendor_name',
        'vendor_type',
        'contact_person',
        'email',
        'mobile',
        'phone',
        'city',
        'country',
        'address',
        'iata_code',
        'airline_code',
        'gst_vat_no',
        'credit_limit',
        'credit_days',
        'opening_balance',
        'remarks',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'credit_limit'    => 'decimal:2',
        'opening_balance' => 'decimal:2',
        'credit_days'     => 'integer',
        'status'          => 'integer',
    ];

    public const TYPES = ['Airline', 'Hotel', 'Visa', 'Insurance', 'Transport', 'Supplier', 'Other'];

    public function account()
    {
        return $this->belongsTo(TransactionAccount::class, 'account_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function getStatusLabelAttribute(): string
    {
        return (int) $this->status === 1 ? 'Active' : 'Inactive';
    }
}
