<?php

namespace App\Imports;

use App\Models\Area;
use Maatwebsite\Excel\Concerns\ToModel;

class AreaImport implements ToModel
{
    public $data;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  __construct(array $data)
    {
        $this->data= $data;
    }
    public function model(array $row)
    {
        $country_id=$this->data['CID'];
        $PID=$this->data['PID'];
        $CTID=$this->data['CTID'];
        return new Area([
            'name'=>$row[0],
            'CID'=>$country_id,
            'PID'=>$PID,
            'CTID'=>$CTID,
        ]);
        $file=Storage::disk('local')->append(''.time().'_error.txt', $error, $separator = PHP_EOL);
    }
}
