<?php

namespace App\Http\Controllers\Umrah;

use App\Http\Controllers\Controller;
use App\Models\Umrah\HotelReservationBrn;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Helpers\Account;

class HotelReservationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:hotel_reservation_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('umrah.reservations.hotel_reservation.index');
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
            'brn'=>'required',
            'booking_date'=>'required',
            'city_id'=>'required',
            'hotel_id'=>'required',
            'checkin'=>'required',
            'checkout'=>'required',
            'purchased_by'=>'required',
        ];
        $message=[
            'brn.required'=>'BRN Required',
            'booking_date.required'=>'Booking Date Required',
            'city_id.required'=>'City Required Required',
            'hotel_id.required'=>'Hotel Required',
            'checkin.required'=>'Checkin Required',
            'checkout.required'=>'Checkout Required',
            'purchased_by.required'=>'Purchased By Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except(['_token']);
        $id=$request->id;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by']=Auth::user()->id;
                $ret=HotelReservationBrn::create($data);
                DB::commit();
                return $ret;
            } else {
                HotelReservationBrn::where('id', $id)->update($data);
                DB::commit();
                return $id;
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
    //@display data in list
    public function get_data(Request $request){
        $result=HotelReservationBrn::with('source','hotel','room')
            ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->paginate(50);
        return $result;
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
        return HotelReservationBrn::find($id);
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
