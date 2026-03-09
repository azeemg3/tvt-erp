<?php

namespace App\Http\Controllers;

use App\Imports\AreaImport;
use Illuminate\Http\Request;
use App\Models\Area;
use DB;
use Excel;
use DataTables;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('areas.index');
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
            'CTID' => 'required',
            'name' => 'required',
        ];
        $message=[
            'CID.required'=>'Country Required',
            'PID.required'=>'Province Required',
            'CTID.required'=>'City Required',
            'name.required'=>'City Name Required',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token']);
        $id=$request->id;
        if($id=='' || $id==0){
            $ret=Area::create($data);
        }else{
            $ret=Area::where('id', $id)->update($data);
        }
        if($ret){
            return response()->json(['success'=>'Added new record Successfully.']);
        }
    }
    //@save data in excel file
    public function save_areas_excel(Request $request){
        $rules=[
            'import_file'=>'required|mimes:xlsx,csv, xls',
            'CTID'=>'required',
        ];
        $message=[
            'import_file.required'=>'File Required',
            'CTID.required'=>'City Required',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token']);
        DB::beginTransaction();
        try {
            if($request->hasFile('import_file')) {
                $file = $request->file('import_file');
                Excel::import(new AreaImport($data), $file);
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
            $data=DB::table('areas')->leftjoin('cities','areas.CTID','cities.id')
                ->select('areas.id AS ID','areas.name AS area_name','cities.name AS city_name')
                ->orderBy('areas.name','DESC')->get();
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
        return Area::find($id);
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
