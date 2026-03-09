<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Storage;

class CityImport implements ToModel
{
    public $country_id;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  __construct($country_id)
    {
        $this->country_id= $country_id;
    }
    public function model(array $row)
    {
        return new City([
            'CID'=>$this->country_id,
            'name'=>$row[0],
        ]);
        $file=Storage::disk('local')->append(''.time().'_error.txt', $error, $separator = PHP_EOL);
    }
}
