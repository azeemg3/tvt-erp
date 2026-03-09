<?php

namespace App\Http\Controllers\Accounts\Reports;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Accounts\HeadAccount;
use App\Models\Accounts\RootAccount;
use App\Models\Accounts\SubHeadAccount;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
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
        $htmlData='';
        $roots=RootAccount::all();
        foreach ($roots as $root) {
            $htmlData .= '<tr class="bg-gradient-info">';
                $htmlData .= '<th colspan="2">0'.$root->id.'-'.$root->name.'</th>';
            $htmlData .= '</tr>';
            $heads=HeadAccount::where('RID', $root->id)->get();
            foreach ($heads as $head){
                $total_asset=0;
                $htmlData .= '<tr>';
                $htmlData .= '<th colspan="2"><span style="margin-left: 25px;">'.$root->id.''.$head->id.'-'.$head->name.'</span></th>';
                $htmlData .= '</tr>';
                $subHeads=SubHeadAccount::where('HID', $head->id)->get();
                foreach ($subHeads as $subHead){
                    $htmlData .= '<tr>';
                    $htmlData .= '<td colspan="2"><span style="margin-left: 35px;">'.$subHead->name.'</span></td>';
                    $htmlData .= '</tr>';
                    $accounts=TransactionAccount::where('PID', $subHead->id)->get();
                    foreach ($accounts as $account) {
                        $total_asset+=Account::ob(date('Y-m-d'),$account->id);
                        $htmlData .= '<tr>';
                        $htmlData .= '<td><span style="margin-left: 200px;">' . $account->Trans_Acc_Name . '</span></td>';
                        $htmlData .= '<td style="text-align: right">'.Account::show_bal(Account::ob(date('Y-m-d'),$account->id)).'</td>';
                        $htmlData .= '</tr>';
                    }
                }
                $htmlData.='<tr>';
                    $htmlData.='<td style="text-align: right">Total '.$head->name.':</td>';
                    $htmlData.='<th style="text-align: right; border-top: double;border-bottom: double">'.Account::show_bal($total_asset).'</th>';
                $htmlData.='</tr>';
            }
        }
        return view('Accounts.reports.balance_sheet.index',compact('htmlData'));
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
