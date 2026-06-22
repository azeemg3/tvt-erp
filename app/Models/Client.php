<?php

namespace App\Models;

use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'client_code',
        'account_id',
        'client_name',
        'email',
        'mobile',
        'co_spo',
        'assigned_user_id',
        'recovery_officer_id',
        'category',
        'credit_limit',
        'credit_days',
        'address',
        'remarks',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'credit_days'  => 'integer',
        'status'       => 'integer',
    ];

    public const CATEGORIES = ['Walk-In Customer', 'Corporate', 'Agent'];

    public function account()
    {
        return $this->belongsTo(TransactionAccount::class, 'account_id', 'id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id', 'id');
    }

    public function recoveryOfficer()
    {
        return $this->belongsTo(User::class, 'recovery_officer_id', 'id');
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
