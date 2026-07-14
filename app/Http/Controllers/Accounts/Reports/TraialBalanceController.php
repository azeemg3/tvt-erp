<?php

namespace App\Http\Controllers\Accounts\Reports;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Http\Request;

class TraialBalanceController extends Controller
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
        // Account::ob($date) returns balance BEFORE $date.
        // Pass tomorrow so "As on today" includes today's postings.
        $asOn = date('Y-m-d');
        $obDate = date('Y-m-d', strtotime('+1 day', strtotime($asOn)));

        $rows = [];
        $dr = 0;
        $cr = 0;

        foreach (TransactionAccount::orderBy('Trans_Acc_Name')->get() as $account) {
            $balance = (float) Account::ob($obDate, $account->id);
            if (abs($balance) < 0.00001) {
                continue;
            }

            $debit = $balance > 0 ? $balance : 0;
            $credit = $balance < 0 ? abs($balance) : 0;
            $dr += $debit;
            $cr += $credit;

            $rows[] = [
                'name'   => $account->Trans_Acc_Name,
                'debit'  => $debit,
                'credit' => $credit,
            ];
        }

        return view('Accounts.reports.trial_balance.index', compact('rows', 'dr', 'cr', 'asOn'));
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
