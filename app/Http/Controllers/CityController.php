<?php

namespace App\Http\Controllers;

use App\Imports\AreaImport;
use App\Imports\CityImport;
use Illuminate\Http\Request;
use App\Models\City;
use DataTables;
use DB;
use Excel;
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('cities.index');

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
        $rules = [
            'CID' => 'required',
            'PID' => 'required',
            'name' => 'required',
        ];
        $message=[
            'CID.required'=>'Country Required',
            'PID.required'=>'Province Required',
            'name.required'=>'City Name Required',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token']);
        $id=$request->id;
        if($id=='' || $id==0){
            $ret=City::create($data);
        }else{
            $ret=City::where('id', $id)->update($data);
        }
        if($ret){
            //return response()->json(['success'=>'Added new record Successfully.']);
            return $ret;
        }
    }
    //@save cities in excel file
    public function save_cities_excel(Request $request){
        $rules=[
            'import_file'=>'required|mimes:xlsx,csv, xls',
            'CID'=>'required',
        ];
        $message=[
            'import_file.required'=>'File Required',
            'CID.required'=>'Country Required',
        ];
        $this->validate($request, $rules, $message);
        DB::beginTransaction();
        try {
            if($request->hasFile('import_file')) {
                $file = $request->file('import_file');
                Excel::import(new CityImport($request->CID), $file);
            }
            DB::commit();
            return response()->json(['success' => 'Added new record Successfully.']);

        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
            ], 400);
        }
    }
    //@listing data
    public function get_data(Request $request){
        if ($request->ajax()) {
            $data=DB::table('cities')->leftjoin('provinces','cities.PID','provinces.id')
                ->leftjoin('countries','cities.CID','countries.id')
                ->select('cities.id AS ID','countries.name AS country_name','cities.name AS city_name','provinces.name AS pName')
                ->orderBy('cities.name','DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit('.$row->ID.')"><i class="fa fa-edit"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
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
        return City::where('CID', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return City::find($id);
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
        return City::destroy($id);
    }
}
