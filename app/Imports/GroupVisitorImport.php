<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\Umrah\AgentUmrahVisitor;
use App\Models\Umrah\GroupDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;

class GroupVisitorImport implements ToModel
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
            return new AgentUmrahVisitor([
                'group_id'=>GroupDetail::where('group_code', $row[0])->first()->id,
                'code'=>$row[2],
                'pax_name'=>$row[3],
                'mofa'=>$row[4],
                'gender'=>$row[5]=='Male'?'1':'2',
                'dob'=>date('Y-m-d',strtotime(trim($row[6]))),
                'age'=>CommonHelper::age(date('d-m-Y',strtotime(trim($row[6])))),
                'nationality'=>Country::where('name', $row[7])->first()->id,
                'passport'=>$row[8],
                'mehram'=>$row[9],
            ]);
        }
        $file=Storage::disk('local')->append(''.time().'_error.txt', $error, $separator = PHP_EOL);
    }
}
