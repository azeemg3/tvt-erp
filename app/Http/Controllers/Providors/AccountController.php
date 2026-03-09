<?php

namespace App\Http\Controllers\Providors;

use App\Helpers\Account;
use App\Http\Controllers\Controller;
use App\Models\Accounts\ServiceProvidor;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use Illuminate\Http\Request;
use DB;
use Auth;
class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('providors.accounts.index');
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
    /*
     * display data in list
     */
    public function get_data(Request $request){
        $tdr=0; $tcr=0; $cb=0;
        $source_id=ServiceProvidor::where('UID',Auth::user()->id)->value('id');
        $source_id=TransactionAccount::where(['PID'=>9, 'Parent_Type'=>$source_id])->value('id');
        $res=Transaction::whereBetween('trans_date', [$request->df, $request->dt])
            ->whereBetween(DB::raw('DATE(created_at)'),Account::financial_year())
            ->where(['trans_acc_id'=>$source_id, 'status'=>1])->get();
        $ob=Account::ob($request->df, $source_id);
        $data='';
        $data.='<tr>';
        $data.='<td colspan="7" align="right">Opening Balance As At '.$request->df.'</td>';
        $data.='<td align="right">'.Account::show_bal($ob).'</td>';
        $data.='</tr>';
        foreach ($res as $item){
            if($item->dr_cr==1){
                $tdr+=$item->amount;
            }
            if($item->dr_cr==2){
                $tcr+=$item->amount;
            }
            $cb=$ob+($tdr-$tcr);
            $data.='<tr>';
            $data.='<td></td>';
            $data.='<td>'.$item->trans_date.'</td>';
            $data.='<td>'.Account::vt($item->vt).'</td>';
            $data.='<td>'.CommonHelper::dsn($item->trans_code).'</td>';
            $data.='<td>'.$item->narration.'</td>';
            $data.='<td>'.(($item->dr_cr==1)?$item->amount:'0.00').'</td>';
            $data.='<td>'.(($item->dr_cr==2)?$item->amount:'0.00').'</td>';
            $data.='<td align="right">'.Account::show_bal($cb).'</td>';
            $data.='</tr>';
        }
        $data.='<tr>';
        $data.='<td colspan="5"></td>';
        $data.='<th> '.number_format($tdr,2).'</th>';
        $data.='<th> '.number_format($tcr,2).'</th>';
        $data.='<th style="text-align: right">'.Account::show_bal($cb).'</th>';
        $data.='</tr>';
        return compact('data','ob');
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
