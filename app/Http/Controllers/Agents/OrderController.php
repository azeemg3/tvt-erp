<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\AccommodationDetails;
use App\Models\Accounts\Agent;
use App\Models\Cms\Quarantine;
use App\Models\TransportDetails;
use App\Models\TravelerInformation;
use Illuminate\Http\Request;
use App\Models\Booking;
use DB;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('agents.orders.index');
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
            'pnr' => 'required',
            'flight' => 'required',
        ];
        $message=[
            'pnr.required'=>'Pnr Required',
            'flight.required'=>'Fligt Required',
        ];
        //create booking
        $data['airline_id']=$request->airline_id;
        $data['pnr']=$request->pnr;
        $data['flight']=$request->flight;
        $data['booking_by']=1;
        $data['payment_type']=1;
        $data['status']=1;
        $data['departure']=date("y-m-d", strtotime($request->dep_date));
        $data['departure_time']=$request->dep_time;
        $data['arrival']=date("y-m-d", strtotime($request->arrival_date));
        $data['arrival_time']=$request->arrival_time;
        $data['booked_by']=Auth::user()->id;
        //accommodation details
        $accData['hotel_name']=$request->hotel_name;
        $accData['hotel_type']=$request->hotel_type;
        $accData['checkin']=$request->checkin.' '.$request->checkin_time;
        $accData['checkout']=$request->arrival.' '.$request->arrival_time;
        //transport_details
        $transData['transport_type']=$request->transport_type;
        $transData['city']=$request->city;
        $BookingID=$request->id;
        DB::beginTransaction();
        try{
            Booking::where('id', $BookingID)->update($data);
            AccommodationDetails::where('BookingID', $BookingID)->update($accData);
            TransportDetails::where('BookingId', $BookingID)->update($transData);
            DB::commit();
            return response()->json(['success'=>'Added new record Successfully.']);
        }catch (\Illuminate\Database\QueryException $e){
            $code = $e->errorInfo[1];
            return response()->json([
                'success' => 'false',
                'errors'  => $e->errorInfo,
                'code'  => $e->errorInfo,
            ], 400);
            DB::rollback();
        }
    }
    //@display data list
    public function get_data(Request $request){
        if(isset($request->agent_id)) {
            $id = Agent::find($request->agent_id)->UID;
            return DB::table('bookings')->join('quarantines','bookings.PkgID','quarantines.id')
                ->join('users','bookings.booked_by','users.id')
                ->where('bookings.booked_by', $id)
                ->select('bookings.*','quarantines.*','users.name')->paginate(15);
        }else {
            return DB::table('bookings')->join('quarantines', 'bookings.PkgID', 'quarantines.id')
                ->join('users', 'bookings.booked_by', 'users.id')
                ->select('bookings.booking_date','bookings.departure','bookings.departure_time', 'bookings.arrival','bookings.status','bookings.id', 'quarantines.pkg_name','quarantines.guest_price', 'users.name')->paginate(15);
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
        $booking=Booking::find($id);
        $pkg=Quarantine::find($booking->PkgID);
        $travller=TravelerInformation::where('BookingID', $id)->get();
        $accDet=AccommodationDetails::where('BookingId', $id)->get();
        return compact('booking','pkg','travller','accDet');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking=Booking::find($id);
        $traveller=TravelerInformation::with('nationality')->where('BookingID', $id)->get();
        $AccDetails=AccommodationDetails::where('BookingID' ,$id)->first();
        $transport=TransportDetails::where('BookingID', $id)->first();
        return compact('booking','traveller','AccDetails','transport');
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
        dd($id);
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
