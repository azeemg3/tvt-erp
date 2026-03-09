<?php

namespace App\Models;

use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelsRate extends Model
{
    use HasFactory;
    protected $fillable=['city_id', 'hotel_id', 'contact', 'currency_id',
        'currency_rate', 'source', 'room_type', 'purchase', 'sale_tax', 'vat',
        'wh', 'oc', 'net_purchase', 'created_by', 'updated_by','status','month'];
    public function city(){
        return $this->belongsTo(City::class,'city_id','id');
    }
    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }
    public function source(){
        return $this->belongsTo(TransactionAccount::class,'source','id');
    }
    public function rt(){
        return $this->belongsTo(RoomType::class,'room_type','id');
    }
    public function hotel_agents(){
        return $this->hasOne(HotelAgentPrice::class,'HRID','id');
    }

}
