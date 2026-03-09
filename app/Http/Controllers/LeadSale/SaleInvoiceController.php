<?php

namespace App\Http\Controllers\LeadSale;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\SaleInvoice;
use App\Models\Lms\LeadHotel;
use App\Models\Lms\Visa;
use App\Models\Lms\Transport;
use App\Models\Lms\OtherSale;
class SaleInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $result=SaleInvoice::find($id);
        if($result->type==1){
            $pax=Ticket::where('SID', $id)->get();
        }
        else if($result->type==2){
            $pax=LeadHotel::where('SID', $id)->get();
        }
        else if($result->type==3){
            $pax=Visa::where('SID', $id)->get();
        }
        else if($result->type==4){
            $pax=Transport::where('SID', $id)->get();
        }
        if($result->type==5) {
            $pax=Ticket::where('SID', $id)->get();
        }
        return compact('result', 'pax');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return SaleInvoice::find($id);
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
