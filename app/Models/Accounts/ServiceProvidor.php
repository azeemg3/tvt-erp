<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvidor extends Model
{
    use HasFactory;
    protected $fillable=['id', 'name', 'code', 'mobile', 'email', 'country', 'province',
        'city_id', 'status', 'address', 'product_includes', 'term_condition', 'created_by',
        'updated_by', 'created_at', 'updated_at','UID'];
}
