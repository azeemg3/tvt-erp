<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Models\Accounts\TransactionAccount;
use App\Models\TransportRateKsa;
use Illuminate\Http\Request;
use DB;
use Auth;

class TransportConfirmationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:transport_confirmation_view', ['only' => ['index']]);
        $this->middleware('permission:transport_confirmation_create', ['only' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('booking_confirmation.transport_confirmation.index');
    }
    //dislay data in list
    public function get_data(Request $request){
        $res=DB::table('agent_umrah_transport_details AS t')
            ->join('agent_umrahs AS a','t.UID','a.id')
            ->join('umrah_transport_cities AS ct','t.from_city','ct.id')
            ->join('umrah_transport_cities AS tc','t.to_city','tc.id')
            ->leftjoin('transport_rate_ksas AS TK','t.id','TK.UID')
            ->leftjoin('users AS u','TK.ack_by','u.id')
            ->leftjoin('transport_rates AS tr','t.TRID','tr.id')
            ->select('t.*',
                DB::raw('(SELECT  px.pax_name FROM agent_umrah_pax_details AS px
                 WHERE t.UID=px.UID LIMIT 1) AS pax_name'),
                DB::raw('(SELECT  count(id) FROM agent_umrah_pax_details AS px
                 WHERE t.UID=px.UID LIMIT 1) AS total_pax'),
                'ct.name AS city_name', 'tc.name AS fcity_name',
                'TK.total AS total','TK.rate AS t_rate', 'TK.remarks AS remarks',
                'u.name AS ack_by','tr.source As source')->where('a.status',1)
            ->whereBetween(DB::raw('DATE(a.created_at)'),Account::financial_year())
            ->when($request->df, function ($query) use ($request) {
                $query->whereBetween(DB::raw('DATE(a.created_at)'),
                    [$request->df, $request->dt]);
            })->when($request->voucher, function ($query) use ($request) {
                $voucher=explode('p',$request->voucher);
                $query->where('a.id', $voucher[1]);
            })
            ->orderBy('t.UID','DESC')
            ->paginate(50);
        return $res;
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
            'rate'=>'required',
            'total'=>'required',
        ];
        $message=[
            'rate.required'=>'Rate Required',
            'total.required'=>'Total Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token']);
        DB::beginTransaction();
        try {
            $data['ack_by']=Auth::user()->id;
            $id=TransportRateKsa::where('UID',$request->UID)->first();
            if($id=='' || $id==null){
                $ret=TransportRateKsa::create($data);
            }else{
                $ret=TransportRateKsa::where('UID', $id->UID)->update($data);
            }
            DB::commit();
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
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
