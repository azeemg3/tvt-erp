<?php

namespace App\Http\Controllers\Accounts\Reports;

use App\Http\Controllers\Controller;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Http\Request;
use DB;

class AccountDayBookController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:account_reports_view', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res=Transaction::where('status',1)
            ->whereDate('trans_date', date('Y-m-d'))
            ->select('*',DB::raw('sum(amount) AS total'))->groupBy('trans_code')->get();
        return view('Accounts.reports.day_book.index',compact('res'));
    }
    //view account details
    public function view_account_day_book($id){
        return Transaction::with('trans_acc')->where('trans_code',$id)->get();
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
        //
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
