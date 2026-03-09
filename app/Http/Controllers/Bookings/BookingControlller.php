<?php

namespace App\Http\Controllers\Bookings;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Bookings\TourBooking;
use App\Models\Bookings\TourPax;
use App\Models\Crm\Agent;
use App\Models\Tours\IntTour;
use Illuminate\Http\Request;
use PDF;
use Auth;
use DB;
class BookingControlller extends Controller
{
    public function index(){
        return view('booking_management.index');
    }
    //@dispaly tour booking list
    public function tour_booking(){
        return view('booking_management.tour_booking.index');
    }
    //@display data in list tour boooking
    public function get_tour_booking(){
        return TourBooking::with('tour_pkg')
            ->whereBetween(DB::raw('DATE(created_at)'), Account::financial_year())
            ->orderByDesc('id')->paginate(15);
    }
    public function tour_booking_details($id){

    }
    //approved international booking
    public function app_int_tour($id){
        $ret=TourBooking::where('id',$id)->update(['status'=>1]);
        if($ret){
            return 1;
        }
    }
    //generate international tour voucher
    public function gen_int_tour_voucher($id){
        $booking_details=TourBooking::find($id);
        $pkg_details=IntTour::where('id',$booking_details->pkg_id)->first();
        $pax_details=TourPax::where('tour_id',$id)->get();
        $data=compact('booking_details','pkg_details','pax_details');
        view()->share('data',$data);
        $pdf= PDF::loadView('booking_management.tour_booking.gen_int_vouhcer',$data);
        return $pdf->stream();
    }
    //save tour pax
    public function save_pax(Request $request){
        $rules=[
            'pax_name'=>'required',
            'gender'=>'required',
            'passport'=>'required',
            'nationality'=>'required',
            'dob'=>'required',
            'age'=>'required',
        ];
        $message=[
            'pax_name.required'=>'Pax Name Required',
            'gender.required'=>'Gender Required',
            'passport.required'=>'Passport Required',
            'nationality.required'=>'Please Select Nationality',
            'dob.required'=>'Date of Birth Required',
            'age.required'=>'Age Required',
        ];
        $this->validate($request, $rules, $message);
        $data=$request->except('token');
        session_start();
        $cnic_photo='';
        if(isset($request->cnic_photos)) {
            foreach ($request->cnic_photos as $photo) {
                $cnic_photo.=url('/storage/app/'.$photo->store('public/umrah/cnic')).',';
            }
            $cnic_photo=rtrim($cnic_photo,',');
        }
        $passport_photos='';
        if(isset($request->cnic_photos)) {
            foreach ($request->passport_photos as $passport_photo) {
                $passport_photos.=url('/storage/app/'.$passport_photo->store('public/umrah/passport')).',';
            }
            $passport_photos=rtrim($cnic_photo,',');
        }
        $vaccine_card_photo='';
        if(isset($request->vaccine_card_photo)) {
            $vaccine_card_photo=url('/storage/app/'.$request->vaccine_card_photo->store('public/umrah/vaccine'));
        }
        $data['title']=$request->title;
            $data['pax_name']=$request->pax_name;
            $data['father_name']=$request->father_name;
            $data['middle_name']=$request->middle_name;
            $data['last_name']=$request->last_name;
            $data['pax_type']=$request->pax_type;
            $data['gender']=$request->gender;
            $data['dob']=$request->dob;
            $data['age']=$request->age;
            $data['cnic']=$request->cnic;
            $data['nationality']=$request->nationality;
            $data['passport_type']=$request->passport_type;
            $data['passport']=$request->passport;
            $data['passport_country']=$request->passport_country;
            $data['passport_issue_date']=$request->issue_date;
            $data['passport_expire_date']=$request->expirty_date;
            $data['cnic_photo']=$cnic_photo;
            $data['passport_photo']=$passport_photos;
            $data['passport_photo']=$vaccine_card_photo;
            $data['created_by']=Auth::user()->id;
            $data['tour_id']=$request->TID;
        $ret[]=TourPax::create($data);
        return $ret;
    }
    //@dispaly tour pax in list
    public function get_tour_pax(Request $request){
        $TID=$request->TID;
        return TourPax::with('country')->where('tour_id',$TID)->get();
    }
    //delete pax
    public function delete_pax($id){
        return TourPax::where('id',$id)->delete();
    }
}
