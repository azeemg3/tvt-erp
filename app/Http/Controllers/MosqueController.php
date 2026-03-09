<?php

namespace App\Http\Controllers;

use App\Imports\MosqueImport;
use App\Models\Mosque;
use Illuminate\Http\Request;
use DB;
use Excel;
use DataTables;

class MosqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mosques.index');
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
            'ARID' => 'required',
            'name' => 'required',
        ];
        $message=[
            'ARID.required'=>'Area Required',
            'name.required'=>'Mosque Name Required',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token']);
        $id=$request->id;
        if($id=='' || $id==0){
            $ret=Mosque::create($data);
        }else{
            $ret=Mosque::where('id', $id)->update($data);
        }
        if($ret){
            return response()->json(['success'=>'Added new record Successfully.']);
        }
    }
    /*
     * store data in excel
     */
    public function save_mosque_excel(Request $request){
        $rules=[
            'import_file'=>'required|mimes:xlsx,csv, xls',
            'ARID'=>'required',
        ];
        $message=[
            'import_file.required'=>'File Required',
            'ARID.required'=>'Area Required',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token']);
        DB::beginTransaction();
        try {
            if($request->hasFile('import_file')) {
                $file = $request->file('import_file');
                Excel::import(new MosqueImport($request->ARID), $file);
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
    /**
     * Dispay data in list
     */
    public function get_data(){
        $data=DB::table('mosques')->leftjoin('areas','mosques.ARID','areas.id')
            ->select('areas.name AS area_name','mosques.name As mosq_name','mosques.id AS ID')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit('.$row->ID.')"><i class="fa fa-edit"></i> </a>';
                $btn =$btn.' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec('.$row->ID.', \''.url('mosques').'/'.$row->ID.'\')"><i class="fa fa-trash"></i> </a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

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
        return Mosque::find($id);
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
        return Mosque::destroy($id);
    }
}
