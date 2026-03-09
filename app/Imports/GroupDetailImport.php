<?php

namespace App\Imports;

use App\Models\Umrah\GroupDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Storage;

class GroupDetailImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $error='';
        if($row[0]!='Group Code') {
            return new GroupDetail([
                'agentID'=>$row[0],
                'group_code'=>trim($row[1]),
                'group_name'=>trim($row[2]),
                'embassy'=>trim($row[5]),
            ]);
        }
        $file=Storage::disk('local')->append(''.time().'_error.txt', $error, $separator = PHP_EOL);
    }
}
