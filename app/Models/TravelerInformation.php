<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelerInformation extends Model
{
    use HasFactory;

    public function nationality(){
        return $this->belongsTo(Country::class,'nationality','id');
    }
}
