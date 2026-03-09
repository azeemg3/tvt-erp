<?php

namespace App\Imports;

use App\Models\Mosque;
use Maatwebsite\Excel\Concerns\ToModel;

class MosqueImport implements ToModel
{
    public $ARID;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct($ARID)
    {
        $this->ARID=$ARID;
    }

    public function model(array $row)
    {
        return new Mosque([
            'ARID'=>$this->ARID,
            'name'=>$row[0]
        ]);
        $file=Storage::disk('local')->append(''.time().'_error.txt', $error, $separator = PHP_EOL);
    }
}
