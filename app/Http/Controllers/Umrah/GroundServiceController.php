<?php

namespace App\Http\Controllers\Umrah;

use App\Http\Controllers\Controller;
use App\Models\Umrah\GroundAdditionalService;
use App\Models\Umrah\GroundService;
use App\Models\Umrah\GsRepersentative;
use Illuminate\Http\Request;
use DB;
use Auth;

class GroundServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'umrah_company'=>'required',
        ];
        $message=[
            'umrah_company.required'=>'Umrah Comany Name Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token','aadult_rate','achild_rate','ainfant_rate','service_name',
            'repersentative_person','repersentative_contact','city_id','insured_qty','got_services_by']);
        $id=$request->id;
        $count=count($request->service_name);
        $rCount=count($request->repersentative_person);
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $ret=GroundService::create($data);
                for($i=0; $i<$count; $i++){
                    if(!empty($request['service_name'][$i])) {
                        $array= ['service_name' => $request['service_name'][$i],
                            'adult_rate' => $request['aadult_rate'][$i], 'child_rate' => $request['achild_rate'][$i],
                            'infant_rate' => $request['ainfant_rate'][$i]
                            , 'got_services_by' => $request['got_services_by'][$i], 'GSID' => $ret->id
                        ];
                        GroundAdditionalService::insert($array);
                    }
                }
                //insert repersentative contact
                for($j=0; $j<$rCount; $j++){
                    $Rarray[]=['city_id'=>$request['city_id'][$j],
                        'contact_person'=>$request['repersentative_person'][$j],
                        'contact_number'=>$request['repersentative_contact'][$j],
                        'GSID'=>$ret->id
                    ];
                }
                GsRepersentative::insert($Rarray);
                DB::commit();
                return $ret;
            } else {
//                GroundService::where('id', $id)->update($data);
            }

        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
