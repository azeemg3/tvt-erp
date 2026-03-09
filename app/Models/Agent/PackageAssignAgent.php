<?php

namespace App\Models\Agent;

use App\Models\Tours\IntTour;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageAssignAgent extends Model
{
    use HasFactory;
    protected $fillable=['pkg_type', 'pkg_id', 'validity', 'agents', 'discount_type',
        'discount', 'created_by', 'updated_by'];

    public function tour_pkg(){
        return $this->belongsTo(IntTour::class,'pkg_id','id');
    }
}
