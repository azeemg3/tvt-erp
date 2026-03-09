<?php

namespace App\Http\Controllers\Reports\LeadReports;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Lms\Lead;
use Illuminate\Http\Request;
use PDF;
use DB;

class CustomerLeadReportsController extends Controller
{
    //customer lead reports
    public function customer_lead_reports(){
        return view('Reports.leadReports.customer.index');
    }
    //print customer lead reports
    public function print_customer_report(Request $request){
        $result=DB::table('leads')->leftJoin('users','leads.created_by','users.id')
            ->leftJoin('users As u','leads.spo','u.id')
        ->select('leads.id','leads.contact_name','leads.status','users.name',
            DB::raw('u.name AS taken_by'),
            DB::raw('(select sum(amount) from transactions where trans_acc_id=leads.ledger AND vt=1 and status=1) AS receipt'),
            DB::raw('(select sum(amount) from transactions where trans_acc_id=leads.ledger AND vt in (4,5,6,7,8)) AS total'))
            ->whereBetween(DB::raw('DATE(leads.created_at)'),Account::financial_year())
            ->groupBy('leads.ledger')->get();
        $data=compact('result');
        view()->share('data', $data);
        $pdf= PDF::loadView('Reports.leadReports.customer.report', $data);
        return $pdf->stream();
    }
}
