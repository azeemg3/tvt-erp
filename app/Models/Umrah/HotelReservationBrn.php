<?php

namespace App\Models\Umrah;

use App\Models\Accounts\TransactionAccount;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelReservationBrn extends Model
{
    use HasFactory;
    protected $fillable=['brn', 'booking_date', 'city_id', 'hotel_id', 'checkin',
        'nights', 'checkout', 'room_type', 'no_room', 'purchased_by', 'currency',
        'currency_rate', 'purchase_rate', 'total_capacity', 'created_by', 'updated_by'];

    public static function dropdown($id=0){
        $list='';
        $result=self::all();
        foreach ($result as $item){
            $list.='<option value="'.$item->id.'" '.($item->id==$id?'selected':'').'>'.$item->brn.'-'.$item->booking_date.'</option>';
        }
        return $list;
    }
    public function source(){
        return $this->belongsTo(TransactionAccount::class, 'purchased_by','id');
    }
    public function hotel(){
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }
    public function room(){
        return $this->belongsTo(RoomType::class,'room_type','id');
    }
}
