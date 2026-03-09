<?php

namespace App\Http\Controllers\Accounts\Reports;

use App\Http\Controllers\Controller;
use App\Models\Accounts\HeadAccount;
use App\Models\Accounts\RootAccount;
use App\Models\Accounts\SubHeadAccount;
use App\Models\Accounts\TransactionAccount;
use App\Helpers\Account;
use Illuminate\Http\Request;

class IncomeStatementController extends Controller
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
        $income=0;
            $heads=HeadAccount::where('RID', 4)->get();
            foreach ($heads as $head){
                $total_income=0;
                $subHeads=SubHeadAccount::where('HID', $head->id)->get();
                foreach ($subHeads as $subHead){
                    $htmlData .= '<tr>';
                    $htmlData .= '<th colspan="2"><span>'.$subHead->name.'</span></th>';
                    $htmlData .= '</tr>';
                    $accounts=TransactionAccount::where('PID', $subHead->id)->get();
                    foreach ($accounts as $account) {
                        $total_income+=Account::ob(date('Y-m-d'),$account->id);
                        $income+=Account::ob(date('Y-m-d'),$account->id);
                        $htmlData .= '<tr>';
                        $htmlData .= '<td><span style="margin-left: 20px;">' . $account->Trans_Acc_Name . '</span></td>';
                        $htmlData .= '<td style="text-align: right">'.Account::show_bal(Account::ob(date('Y-m-d'),$account->id)).'</td>';
                        $htmlData .= '</tr>';
                    }
                }
                $htmlData.='<tr>';
                $htmlData.='<td style="text-align: right">Total '.$head->name.':</td>';
                $htmlData.='<th style="text-align: right; border-top: double;border-bottom: double">'.Account::show_bal($total_income).'</th>';
                $htmlData.='</tr>';
            }
            //expense
        $expnse=0;
        $heads=HeadAccount::where('RID', 5)->get();
        foreach ($heads as $head){
            $total_asset=0;
            $subHeads=SubHeadAccount::where('HID', $head->id)->get();
            foreach ($subHeads as $subHead){
                $htmlData .= '<tr>';
                $htmlData .= '<th colspan="2"><span>'.$subHead->name.'</span></th>';
                $htmlData .= '</tr>';
                $accounts=TransactionAccount::where('PID', $subHead->id)->get();
                foreach ($accounts as $account) {
                    $total_asset+=Account::ob(date('Y-m-d'),$account->id);
                    $expnse+=Account::ob(date('Y-m-d'),$account->id);
                    $htmlData .= '<tr>';
                    $htmlData .= '<td><span style="margin-left: 20px;">' . $account->Trans_Acc_Name . '</span></td>';
                    $htmlData .= '<td style="text-align: right">'.Account::show_bal(Account::ob(date('Y-m-d'),$account->id)).'</td>';
                    $htmlData .= '</tr>';
                }
            }
            $htmlData.='<tr>';
            $htmlData.='<td style="text-align: right">Total '.$head->name.':</td>';
            $htmlData.='<th style="text-align: right; border-bottom: double">'.Account::show_bal($total_asset).'</th>';
            $htmlData.='</tr>';
        }
        $htmlData.='<tr>';
        $htmlData.='<td style="text-align: right">Net Income/Loss</td>';
        $htmlData.='<th style="text-align: right; border-top: double;border-bottom: double">'.Account::show_bal(($income)-($expnse)).'</th>';
        $htmlData.='</tr>';
        return view('Accounts.reports.income_statement.index',compact('htmlData'));
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
