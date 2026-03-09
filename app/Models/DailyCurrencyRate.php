<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyCurrencyRate extends Model
{
    use HasFactory;
    protected $fillable=['country', 'currency_symbol', 'rate', 'created_by',
        'updated_by', 'created_at', 'updated_at'];
    public function country(){
        return $this->belongsTo(Country::class, 'country','id');
    }
    protected $casts = [
        'created_at' => "datetime:Y-m-d h:i:s",
    ];
}
