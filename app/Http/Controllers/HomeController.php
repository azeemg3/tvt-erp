<?php

namespace App\Http\Controllers;

use App\Jobs\UmrahVoucherEmailJob;
use App\Mail\UmrahVouhcerEmail;
use App\Models\Accounts\Agent;
use App\Models\Accounts\SubHeadAccount;
use App\Models\Accounts\TransactionAccount;
use App\Models\Crm\AgentUmrah;
use App\Models\Currency;
use App\Models\Umrah\GroupDetail;
use Illuminate\Http\Request;
use Auth;
use Spatie\Permission\Models\Permission;
use Session;
use DB;
use Illuminate\Support\Facades\Mail;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $result=Permission::all();
//        $html='';
//        foreach ($result as $item){
//            $html.="Permission::create([
//            'form' => $item->form,
//            'menu' => $item->menu,
//            'parent_id' =>'".$item->parent_id."',
//            'name' => '".$item->name."',
//            'guard_name' => '".$item->guard_name."',
//            'created_at' => \Carbon\Carbon::now(),
//            'updated_at' => \Carbon\Carbon::now()
//            ]);";
//            $html.='<br>';
//        }
//        echo $html;
//        dd();
//        UmrahVoucherEmailJob::dispatch()->delay(now()->addSeconds(2));
//        Mail::to('azeemkhalidg3@gmail.com')->send(new UmrahVouhcerEmail());
        if(Auth::user()->getRoleNames()[0]=='Admin') {
            $this->middleware('permission:dashboard_view', ['only' => ['index']]);
            return view('home');
        }else if(Auth::user()->getRoleNames()[0]=='Accountant'){
            return view('Accounts.index');
        }
        else{
//            return redirect()->route('lead.index');
            return view('home');
        }
    }
    //all main menu noticfication
    public function menu_notification(){
        //count umrah group unseen by master
        $countUmrahGroups=GroupDetail::where('seen',0)->count();
        $countAgents=Agent::where('seen',0)->count();
        $countUmrahTrips=DB::table('agent_umrahs')->where('seen',0)->count();
        //wallet
        $countAgentWallet=DB::table('agent_wallets')->where('seen',0)->count();
        $total_agents=$countAgents+$countUmrahTrips+$countAgentWallet;
        return compact('countUmrahGroups','countAgents','total_agents',
            'countUmrahTrips','countAgentWallet');
    }
    public function seen_notification($tn){
        return DB::table($tn)->where('seen',0)->update(['seen'=>1]);
    }
}
