<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrmController extends Controller
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

    public function fetch_ticket($ticket)
    {
        $parts = explode('-', $ticket, 2);
        $airlineCode = trim($parts[0] ?? '');
        $ticketNo = trim($parts[1] ?? '');

        if ($airlineCode === '' || $ticketNo === '') {
            return response()->json(['success' => false, 'data' => null]);
        }

        $ticketNoDigits = str_replace(['-', ' '], '', $ticketNo);

        $result = DB::connection('crm')->table('add_sale')
            ->where('airline_code', $airlineCode)
            ->where(function ($query) use ($ticketNo, $ticketNoDigits) {
                $query->where('ticket_no', $ticketNo)
                    ->orWhere('ticket_no', $ticketNoDigits)
                    ->orWhereRaw("REPLACE(REPLACE(ticket_no, '-', ''), ' ', '') = ?", [$ticketNoDigits]);
            })
            ->first();

        return response()->json([
            'success' => (bool) $result,
            'data' => $result,
        ]);
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
