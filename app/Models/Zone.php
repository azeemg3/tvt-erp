<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    protected $fillable=['Z_Name', 'CTID'];

    public function country(){
        return $this->belongsTo(Country::class,'CTID', 'id');
    }
}
