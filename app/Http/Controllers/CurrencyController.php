<?php

namespace App\Http\Controllers;

use App\Models\DailyCurrencyRate;
use Illuminate\Http\Request;
use App\Models\Currency;
use Session;
use Auth;
class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result=\AmrShawky\LaravelCurrency\Facade\Currency::rates()->latest()
            ->get();
        return view('Setup.Currencies.index',compact('result'));
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
        $rules=[
            'rate'=>'required',
            'country'=>'required',
        ];
        $mesage=[
            'currency_name.required'=>'Currency Name required',
            'country.required'=>'Country required'
        ];
        $this->validate($request, $rules, $mesage);
        $id=$request->id;
        $data=request()->except(['_token']);
        if($id==0 || $id==''){
            $data['created_by']=Auth::user()->id;
            $ret=Currency::create($data);
            DailyCurrencyRate::create($data);
        }else{
            $data['updated_by']=Auth::user()->id;
            $ret=Currency::where('id', $id)->update($data);
            $data['created_by'] = Auth::user()->id;
            DailyCurrencyRate::create($data);
        }
        if($ret){
            return response()->json(['success'=>'Added new record Successfully.']);
        }
    }
    //@dispay the listing data
    public function get_data(Request $request){
        return Currency::with('country')->orderByDesc('id')->get();
    }
    //@display fetch api currenceis
    public function get_apicurrency($base='SAR'){
        $result=\AmrShawky\LaravelCurrency\Facade\Currency::rates()->latest()->base($base)
            ->get();
        Session::put('currencies',$result);
        return view('Setup.Currencies.currency_api',compact('result','base'));
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
        return Currency::find($id);
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
        return Currency::destroy($id);
    }
    /*
     * currency history
     */
    public function currency_history(){
        return view('Setup.Currencies.currency_history');
    }
    public function get_currency_history(){
        return DailyCurrencyRate::with('country')->orderByDesc('id')->get();
    }
}
