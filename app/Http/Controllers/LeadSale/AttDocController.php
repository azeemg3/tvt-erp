<?php

namespace App\Http\Controllers\LeadSale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Store;
use App\Models\Lms\ClientDocument;
use DB;
use Auth;

class AttDocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ClientDocument::where('leadId', $request->leadID)->paginate(15);
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
            'doc_type'=>'required',
            'e_number'=>'required',
            'pax_name'=>'required',
            'doc_url'=>'required',
        ];
        $message=[
            'doc_type.required'=>'Document Type Required',
            'e_number.required'=>'E-Number Required',
            'pax_name.required'=>'Pax Name Required',
            'doc_url.required'=>'Please Attached Document file',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token']);
        $id=$request->id;
        $file = $request->doc_url->store('public/documents');
        $data['doc_url']=$file;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                ClientDocument::create($data);
            } else {
                ClientDocument::where('id', $id)->update($data);
            }
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $code,
            ], 400);
        }
        return response()->json(['success' => 'Added new record Successfully.']);

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
        return ClientDocument::find($id);
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
