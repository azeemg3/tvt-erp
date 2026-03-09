<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Models\HotelRateKsa;
use Illuminate\Http\Request;
use DB;
use Auth;

class HotelConfirmationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:hotel_confirmation_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('booking_confirmation.hotel_confirmation.index');
    }
    //dislay data in list
    public function get_data(Request $request){
        $res=DB::table('agent_umrah_hotel_details AS h')
            ->join('cities','h.city','cities.id')
            ->join('hotels','h.hotel_id','hotels.id')
            ->join('agent_umrahs AS a','h.UID','a.id')
            ->leftjoin('hotel_rate_ksas AS KH','h.id','KH.UID')
            ->leftjoin('users AS u','KH.ack_by','u.id')
            ->leftjoin('hotels_rates AS hr','h.HRID','hr.id')
            ->select('h.*', 'cities.name As city_name','hotels.name as hotel_name',
                DB::raw('(SELECT  px.pax_name FROM agent_umrah_pax_details AS px
                 WHERE h.UID=px.UID LIMIT 1) AS pax_name'),
                DB::raw('(SELECT  count(id) FROM agent_umrah_pax_details AS px
                 WHERE h.UID=px.UID LIMIT 1) AS total_pax'), 'KH.total AS total',
                'KH.rate AS h_rate', 'KH.remarks AS remarks', 'u.name AS ack_by',
                'hr.source AS source')
            ->where('a.status',1)
            ->whereBetween(DB::raw('DATE(a.created_at)'),Account::financial_year())
            ->when($request->df, function ($query) use ($request) {
                $query->whereBetween(DB::raw('DATE(a.created_at)'),
                    [$request->df, $request->dt]);
            })->when($request->voucher, function ($query) use ($request) {
                $voucher=explode('p',$request->voucher);
                $query->where('a.id', $voucher[1]);
            })->orderBy('h.UID','DESC')
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
                $ret=HotelRateKsa::create($data);
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
    //save rate added by ksa staff
}
