<?php

namespace App\Http\Controllers;
use App\Events\NotificationEvent;
use App\Helpers\Account;
use App\Models\Accounts\TransactionAccount;
use App\Models\Lms\LeadHotel;
use App\Models\Lms\OtherSale;
use App\Models\Lms\Receipt;
use App\Models\Lms\Refund;
use App\Models\Lms\Transport;
use App\Models\Lms\Visa;
use App\Models\SaleInvoice;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\LeadNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeadClientWelcome;
use Illuminate\Http\Request;
use App\Models\Lms\Lead;
use Auth;
use DB;
use App\Models\LeadConversation;
class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lead_create|lead_view|lead_edit|lead_delete|My Leads', ['only' => ['index','store']]);
        $this->middleware('permission:lead_create', ['only' => ['create','store']]);
        $this->middleware('permission:lead_edit', ['only' => ['edit','update']]);
        $this->middleware('permission:lead_delete', ['only' => ['destroy']]);
        $this->middleware('permission:my_leads_view', ['only' => ['my_leads']]);
        $this->middleware('permission:all_leads_view', ['only' => ['all_leads']]);
        $this->middleware('permission:pending_leads_view', ['only' => ['pending_leads']]);
    }
    public function index()
    {
        $leads=Lead::all();
        $collection = collect($leads);
        $pl = $collection->where('status', 0)->count();
        $tl = $collection->where('status', 1)->count();
        $process = $collection->where('status', 2)->count();
        $successful = $collection->where('status', 3)->count();
        $unsuccessful = $collection->where('status', 4)->count();
        $total = $collection->count();
        return view('Lms.index', compact('pl', 'tl','process',
            'successful', 'unsuccessful', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Lms.create_lead');
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
            'contact_name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'services' => 'required',
        ];
        $message=[
            'contact_name.required'=>'Contact Name Required',
            'mobile.required'=>'Mobile Number Required',
            'email.required'=>'Email Required',
            'services.required'=>'Please select Client Required Services',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token', 'services','save']);
        $id=$request->id;
        $data['services']=json_encode($request->services);
        if($id=='' || $id==0){
            $data['created_by']=Auth::user()->id;
            $data['status']=$request->save==1?'1':'0';
            $ret=Lead::create($data);
            //Mail::to($request->email)->send(new LeadClientWelcome());
        }else{
            $ret=Lead::where('id', $id)->update($data);
        }
        if($ret){
            return response()->json(['success'=>'Added new record Successfully.']);
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
        $status=Lead::find($id);
        if($status->status==0){
            $status=Lead::where('id', $id)->update(['status'=>1, 'spo'=>Auth::user()->id]);
        }else{
            $status=0;
        }
        $result=DB::table('leads')->leftjoin('countries', 'leads.CID','=', 'countries.id')
            ->leftJoin('cities', 'leads.CTID','=', 'cities.id')
            ->leftJoin('users', 'leads.created_by','=', 'users.id')
            ->select('leads.*','countries.name', 'cities.name AS city', 'users.name AS created_by')->where('leads.id', $id)->get();
        $array=str_replace( array('[',']','\'', '"','' , ';', '<', '>' ), '', $result[0]->services);
        $services=explode(',',$array);
        $SID=SaleInvoice::where('leadId', $id)->get(['id']);
        $ticketSale=Ticket::whereIn('SID', $SID)->sum('receiveable');
        $hotelSale=LeadHotel::whereIn('SID', $SID)->sum('receiveable');
        $visaSale=Visa::whereIn('SID', $SID)->sum('receiveable');
        $tranportSale=Transport::whereIn('SID', $SID)->sum('receiveable');
        $otherSale=OtherSale::whereIn('SID', $SID)->sum('receiveable');
        $netSale=(($ticketSale)+($hotelSale)+($visaSale)+($tranportSale)+($otherSale));
        $ref=(Refund::where('leadId', $id)->sum('refund_amount')+Refund::where('leadId', $id)->sum('service_charges'));
        $receipt=Receipt::where('leadId', $id)->sum('amount');
        $balance=($netSale)-($ref)-($receipt);

        return view('Lms.lead_details',compact(['result', 'status'],'netSale','ref', 'receipt', 'balance','services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=Lead::find($id);
        return view('Lms.edit',compact('data'));
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
    //@pending leads
    public function pending_leads(){
        $result=Lead::Where('spo', 0)->orWhere('spo', Auth::user()->id)->where('status', 0)
            ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->orderBy('id', 'DESC')->get();
        return view('Lms.pending_leads',compact(['result']));
    }
    //@my leads list
    public function my_leads(){
        return view('Lms.my_leads');
    }
    public function get_my_leads(Request $request){
        return Lead::where('spo', Auth::user()->id)
            ->whereBetween(DB::raw('created_at'),Account::financial_year())
            ->orderBy('id', 'DESC')->orderBy('status', 'ASC')->paginate(15);
    }
    //@all leads list
    public function all_leads(){
        return view('Lms.all_leads');
    }
    public function get_all_leads(Request $request){

        $query=Lead::query();
        if(isset($request->df) && isset($request->dt)){
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->df, $request->dt]);
        }
        if(isset($request->contact_name)){
            $query->where('contact_name','like','%'.$request->contact_name.'%');
        }
        if(isset($request->mobile)){
            $query->where('mobile',$request->mobile);
        }
        return $query->orderBy('id', 'DESC')
            ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->orderBy('status', 'ASC')
            ->paginate(15);


    }
    //@lead conversation with client about what he said what he expected
    public function lead_conversation(Request $request){
        $rules = [
            'comment' => 'required',
        ];
        $message=[
            'comment.required'=>'Comment required',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token']);
        return LeadConversation::create($data);

    }
    //@fetch lead conversation againt lead id
    public function get_lead_conversation($id){
        return LeadConversation::where('leadId', $id)->get();
    }
    //@showing lead alerts
    public function lead_alerts(){
        return Lead::where('spo', 0)->orWhere('spo', Auth::user()->id)->where('status', 0)->count();
    }
    //get lead details against lead id
    public function get_lead_details($id){
        return Lead::find($id);
    }
    //@create ledger on requested
    public function lead_ledger(Request $request){
        $rules = [
            'Trans_Acc_Name' => 'required|unique:transaction_accounts,Trans_Acc_Name',
        ];
        $message=[
            'Trans_Acc_Name.required'=>'Trans Account Required',
        ];
        $this->validate($request, $rules, $message);
        $data=request()->except(['_token']);
        $id=$request->id;
        $data['PID']=2;
        $data['editable']=1;
        $data['Parent_Type']=$request->leadId;
        try {
            $ret = TransactionAccount::create($data);
            Lead::where('id', $request->leadId)->update(['ledger'=>$ret->id]);
        }catch (\Illuminate\Database\QueryException $e) {
            $code = $e->errorInfo[2];
            return response()->json([
                'error' => 'false',
                'errors' => $e->errorInfo,
            ], 400);
        }
        return response()->json(['success'=>'Added new record Successfully.']);
    }
    //lead notification
    public function notify(Request $request){
        $data=$request->all();
        $user=User::first();
        $user->notify(new LeadNotification($data));
        event(new NotificationEvent('Received a notification from website'));
    }
}
