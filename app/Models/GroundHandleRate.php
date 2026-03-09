<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroundHandleRate extends Model
{
    use HasFactory;
    protected $fillable=['name', 'currency_id', 'currency_rate', 'validity_from', 'validity_to',
        'purchase_price', 'sale_tax', 'vat', 'with_holding', 'net_sale', 'created_by',
        'updated_by', 'comp_name','contact_details', 'rate'];
}
