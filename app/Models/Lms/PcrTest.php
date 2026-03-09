<?php

namespace App\Models\Lms;

use App\Models\Airline;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcrTest extends Model
{
    use HasFactory;
    protected $fillable=['test_date', 'pax_name', 'pax_type', 'lab_name', 'airline_id',
        'rate', 'receiveable', 'receiveable_id', 'currency_rate', 'currency_id', 'SID',
        'payable', 'payable_id', 'trans_code', 'profit','discount'];

    public function airline(){
        return $this->belongsTo(Airline::class,'airline_id','id');
    }
}
