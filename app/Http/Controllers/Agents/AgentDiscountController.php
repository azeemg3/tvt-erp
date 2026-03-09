<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent\PackageAssignAgent;
use App\Models\Tours\IntTour;
use Illuminate\Http\Request;
use DB;
use Auth;

class AgentDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agents.custom_pkg_discount');
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
            'pkg_type'=>'required',
            'pkg_id'=>'required',
            'validity'=>'required',
            'agents'=>'required',
            'discount_type'=>'required',
            'discount'=>'required',
        ];
        $message=[
            'pkg_type.required'=>'Package Type Required',
            'pkg_id.required'=>'Package Required',
            'validity.required'=>'Validity Required',
            'agents.required'=>'Agents Required',
            'discount_type.required'=>'Discount Type Required',
            'discount.required'=>'Discount Value Required',
        ];
        $this->validate($request,$rules,$message);
        $data=request()->except(['_token']);
        $data['agents']=implode(',',$request->agents);
        $id=$request->id;
        DB::beginTransaction();
        try{
            if($id==0 || $id==''){
                $data['created_by']=Auth::user()->id;
                $ret=PackageAssignAgent::create($data);
            }else{
                PackageAssignAgent::where('id',$id)->update($data);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);
        }catch (QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
        }
    }
    //@display data in list
    public function get_data(){
        return PackageAssignAgent::with('tour_pkg')->paginate(15);
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
    //@fetch tours accordingly types
    public static function fetch_tour_pkg($id){
        if($id==1){
            $result=IntTour::all();
        }
        return $result;
    }
}
