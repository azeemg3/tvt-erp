<?php

namespace App\Models\Umrah;

use App\Models\Accounts\TransactionAccount;
use App\Models\UmrahTransportCity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportReservationBrn extends Model
{
    use HasFactory;
    protected $fillable=['brn', 'booking_date', 'transport_co', 'cycle', 'vehicle_type',
        'arrival_date', 'total_capacity', 'purchased_by', 'currency', 'currency_rate',
        'purchase_rate', 'created_by', 'updated_by','sector_details'];

    public static function dropdown($id=0){
        $list='';
        $result=self::all();
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'" '.($item->id==$id?'selected':'').'>'.$item->brn.'-'.$item->booking_date.'</option>';
        }
        return $list;
    }
    public function source(){
        return $this->belongsTo(TransactionAccount::class,'purchased_by','id');
    }
    public function trans_comp(){
        return $this->belongsTo(TransportCompany::class,'transport_co','id');
    }
    public function trans_route(){
        return $this->belongsTo(TransportCycle::class,'cycle','id');
    }
    public function sectors(){
        return $this->hasMany(TransportBrnSector::class, 'TRBID','id');
    }
    public function trans_brn(){
        return $this->hasMany(TransportBrn::class,'TRBRN','id');
    }

}
