<?php

namespace App\Models;

use App\Models\Accounts\TransactionAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRate extends Model
{
    use HasFactory;
    protected $fillable=['from_city', 'to_city', 'source', 'transport_type',
        'purchase', 'sale_tax', 'vat', 'wh', 'oc', 'net_purchase', 'contact_number',
        'currency_id', 'currency_rate', 'created_by', 'updated_by','status'];

    public function fromCity(){
        return $this->belongsTo(UmrahTransportCity::class,'from_city','id');
    }
    public function toCity(){
        return $this->belongsTo(UmrahTransportCity::class,'to_city','id');
    }
    public function source(){
        return $this->belongsTo(TransactionAccount::class,'source','id');
    }
    public function transport_agents(){
        return $this->hasOne(TransportAgentPrice::class,'TRID','id');
    }
}
