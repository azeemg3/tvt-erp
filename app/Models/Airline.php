<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airline extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'iata_code',
        'icao_code',
        'numeric_code',
        'country',
        'remarks',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function countryInfo()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }

    public function getStatusLabelAttribute(): string
    {
        return (int) $this->status === 1 ? 'Active' : 'Inactive';
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->iata_code ? $this->iata_code.' - '.$this->name : $this->name;
    }

    public static function dropdown($id = 0)
    {
        $list = '';
        $query = self::query()->orderBy('name');

        if ($id) {
            $query->where(function ($q) use ($id) {
                $q->where('status', 1)->orWhere('id', $id);
            });
        } else {
            $query->where('status', 1);
        }

        foreach ($query->get() as $item) {
            $selected = ((int) $item->id === (int) $id) ? 'selected' : '';
            $list .= '<option '.$selected.' value="'.$item->id.'">'.e($item->display_name).'</option>';
        }

        return $list;
    }
}
