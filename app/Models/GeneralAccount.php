<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralAccount extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'nic',
        'address',
        'city',
        'phone',
        'is_spo',
        'is_ro',
        'is_marketing_officer',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_spo'               => 'boolean',
        'is_ro'                => 'boolean',
        'is_marketing_officer' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
