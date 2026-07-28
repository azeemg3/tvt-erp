<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Lms\Refund;
use App\Models\SaleInvoice;
use App\Models\Ticket;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Helpers\Account;
use DB;
use Auth;
use Config;

class TicketRefundController extends Controller
{
    /**
     * List ticket refunds (accounts sale module).
     */
    public function index(Request $request)
    {
        $result = DB::table('refunds')
            ->leftJoin('transaction_accounts', 'refunds.client_id', '=', 'transaction_accounts.id')
            ->select('refunds.*', 'transaction_accounts.Trans_Acc_Name')
            ->where('refunds.refund_to', 1)
            ->when($request->df && $request->dt, function ($query) use ($request) {
                $query->whereBetween('refunds.refund_date', [$request->df, $request->dt]);
            })
            ->when($request->filled('inv_no'), function ($query) use ($request) {
                $query->where('refunds.SID', $request->inv_no);
            })
            ->when($request->ledger, function ($query) use ($request) {
                $query->where('refunds.client_id', $request->ledger);
            })
            ->orderBy('refunds.id', 'desc')
            ->paginate(1000);
        return $result;
    }

    /**
     * Store (create or update) a ticket refund and post inverse transactions
     * mirroring the original ticket sale entries (vt=4) in reverse (vt=9).
     */
    public function store(Request $request)
    {
        $rules = [
            'SID' => 'required|numeric|min:1',
            'rec_id' => 'required|numeric|min:1',
            'pax_name' => 'required',
            'inv_date' => 'required',
            'refund_date' => 'required',
            'refund_amount' => 'required|numeric|min:0.01',
            'vendor_charges' => 'nullable|numeric|min:0',
            'service_charges' => 'nullable|numeric|min:0',
            'ledger' => 'required|numeric',
            'payable_id' => 'required|numeric',
        ];
        $message = [
            'SID.required' => 'Invoice No Required',
            'rec_id.required' => 'Please Select Pax',
            'rec_id.min' => 'Please Select Pax',
            'pax_name.required' => 'Pax Name Required',
            'inv_date.required' => 'Invoice Date Required',
            'refund_date.required' => 'Refund Date Required',
            'refund_amount.required' => 'Refund Amount Required',
            'ledger.required' => 'Client Account Missing, Re-Select Invoice',
            'payable_id.required' => 'Vendor Account Missing, Re-Select Pax',
        ];
        $this->validate($request, $rules, $message);

        $refundAmount = (float) $request->refund_amount;
        $vendorCharges = (float) ($request->vendor_charges ?: 0);
        $serviceCharges = (float) ($request->service_charges ?: 0);
        $payable = (float) ($request->payable ?: 0);
        $comRec = (float) ($request->com_rec ?: 0);
        $comPaid = (float) ($request->com_paid ?: 0);
        $whAir = (float) ($request->wh_air ?: 0);
        $pstPaid = (float) ($request->pst_paid ?: 0);
        $psf = (float) ($request->psf ?: 0);
        $discount = (float) ($request->discount ?: 0);
        $whClient = (float) ($request->wh_client ?: 0);
        $agentAmount = (float) ($request->agent_amount ?: 0);
        $totalTaxes = (float) ($request->total_taxes ?: 0);
        $vendorRecovery = max(0, $payable - $vendorCharges);
        $netRefund = $refundAmount - $vendorCharges - $serviceCharges;

        if ($netRefund < 0) {
            return response()->json([
                'errors' => ['refund_amount' => ['Charges cannot exceed Refund Amount']],
            ], 422);
        }

        $data = [
            'SID' => $request->SID,
            'rec_id' => $request->rec_id,
            'refund_to' => 1,
            'refund_type' => $request->refund_type ?: 0,
            'pax_name' => $request->pax_name,
            'inv_date' => $request->inv_date,
            'refund_date' => $request->refund_date,
            'source' => $request->source ?: null,
            'airline' => $request->airline ?: null,
            'sector' => $request->sector,
            'refund_sector' => $request->refund_sector,
            'ticket_no' => $request->ticket_no,
            'refund_amount' => $refundAmount,
            'vendor_charges' => $vendorCharges,
            'service_charges' => $serviceCharges,
            'net_refund' => $netRefund,
            'payable' => $payable,
            'refund_taxes' => $totalTaxes,
            'com_rec' => $comRec,
            'com_paid' => $comPaid,
            'wh_air' => $whAir,
            'pst_paid' => $pstPaid,
            'psf' => $psf,
            'discount' => $discount,
            'wh_client' => $whClient,
            'agent_amount' => $agentAmount ?: null,
            'agent_id' => $request->agent_id ?: null,
            'vendor_id' => $request->payable_id,
            'client_id' => $request->ledger,
            'remarks' => $request->remarks ?: '',
            'currency' => $request->currency ?: 1,
            'currency_rate' => $request->currency_rate ?: 1,
            'status' => 1,
        ];

        $tdata = [
            'trans_date' => date('Y-m-d'),
            'vt' => 9,
            'status' => 1,
            'payment_type' => $request->payment_type,
            'narration' => 'Ticket Refund Inv#'.$request->SID.' ('.$request->pax_name.') '.$request->remarks,
        ];

        $amounts = compact(
            'vendorRecovery', 'netRefund', 'serviceCharges', 'comRec', 'comPaid',
            'whAir', 'pstPaid', 'psf', 'discount', 'whClient', 'agentAmount'
        );

        $id = $request->id;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by'] = Auth::user()->id;
                $data['trans_code'] = Account::trans_code();
                $tdata['Created_By'] = Auth::user()->id;
                Refund::create($data);
                $this->post_refund_transactions(
                    $tdata,
                    $data['trans_code'],
                    $request->payable_id,
                    $request->ledger,
                    $request->agent_id,
                    $amounts
                );
            } else {
                $refund = Refund::findOrFail($id);
                $trans_code = $refund->trans_code;
                if (empty($trans_code)) {
                    $trans_code = Account::trans_code();
                    $data['trans_code'] = $trans_code;
                }
                $data['updated_by'] = Auth::user()->id;
                $refund->update($data);
                Transaction::where('trans_code', $trans_code)->delete();
                $tdata['Created_By'] = Auth::user()->id;
                $this->post_refund_transactions(
                    $tdata,
                    $trans_code,
                    $request->payable_id,
                    $request->ledger,
                    $request->agent_id,
                    $amounts
                );
            }
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $code = $e->errorInfo[1];
            if ($code == 1062) {
                return response()->json([
                    'errors' => ['rec_id' => [1062]],
                ], 422);
            }
            return response()->json([
                'success' => 'false',
                'errors' => $e->errorInfo,
                'code' => $code,
            ], 400);
        }
        return response()->json(['success' => 'Refund Saved Successfully.']);
    }

    /**
     * Post inverse of ticket sale transactions for a refund.
     */
    private function post_refund_transactions($tdata, $trans_code, $vendor_acc, $client_acc, $agent_id, $amounts)
    {
        $tdata['trans_code'] = $trans_code;

        // Dr vendor (recover from airline/vendor) — inverse of Cr vendor on sale
        if ($amounts['vendorRecovery'] > 0) {
            $tdata['dr_cr'] = 1;
            $tdata['trans_acc_id'] = $vendor_acc;
            $tdata['amount'] = $amounts['vendorRecovery'];
            Transaction::create($tdata);
        }

        // Cr client (credit note) — inverse of Dr client on sale
        if ($amounts['netRefund'] > 0) {
            $tdata['dr_cr'] = 2;
            $tdata['trans_acc_id'] = $client_acc;
            $tdata['amount'] = $amounts['netRefund'];
            Transaction::create($tdata);
        }

        // Dr commission received — inverse of Cr com_rec on sale
        if ($amounts['comRec'] > 0) {
            $tdata['dr_cr'] = 1;
            $tdata['trans_acc_id'] = Config::get('constant.ticket_com_rev');
            $tdata['amount'] = $amounts['comRec'];
            Transaction::create($tdata);
        }

        // Cr commission paid — inverse of Dr com_paid on sale
        if ($amounts['comPaid'] > 0) {
            $tdata['dr_cr'] = 2;
            $tdata['trans_acc_id'] = Config::get('constant.ticket_com_paid');
            $tdata['amount'] = $amounts['comPaid'];
            Transaction::create($tdata);
        }

        // Cr WH air — inverse of Dr wh_air on sale
        if ($amounts['whAir'] > 0) {
            $tdata['dr_cr'] = 2;
            $tdata['trans_acc_id'] = Config::get('constant.wh_tax');
            $tdata['amount'] = $amounts['whAir'];
            Transaction::create($tdata);
        }

        // Cr PST paid — inverse of Dr pst_paid on sale
        if ($amounts['pstPaid'] > 0) {
            $tdata['dr_cr'] = 2;
            $tdata['trans_acc_id'] = Config::get('constant.pst');
            $tdata['amount'] = $amounts['pstPaid'];
            Transaction::create($tdata);
        }

        // Dr PSF — inverse of Cr psf on sale
        if ($amounts['psf'] > 0) {
            $tdata['dr_cr'] = 1;
            $tdata['trans_acc_id'] = Config::get('constant.psf_code');
            $tdata['amount'] = $amounts['psf'];
            Transaction::create($tdata);
        }

        // Cr discount allowed — inverse of Dr discount on sale
        if ($amounts['discount'] > 0) {
            $tdata['dr_cr'] = 2;
            $tdata['trans_acc_id'] = Config::get('constant.dis_allowed');
            $tdata['amount'] = $amounts['discount'];
            Transaction::create($tdata);
        }

        // Dr WH client — inverse of Cr wh_client on sale
        if ($amounts['whClient'] > 0) {
            $tdata['dr_cr'] = 1;
            $tdata['trans_acc_id'] = Config::get('constant.wh_tax');
            $tdata['amount'] = $amounts['whClient'];
            Transaction::create($tdata);
        }

        // Dr agent + Cr agent commission expense — inverse of sale agent entries
        if ($agent_id && $amounts['agentAmount'] > 0) {
            $tdata['dr_cr'] = 1;
            $tdata['trans_acc_id'] = $agent_id;
            $tdata['amount'] = $amounts['agentAmount'];
            Transaction::create($tdata);

            $tdata['dr_cr'] = 2;
            $tdata['trans_acc_id'] = Config::get('constant.agent_com_exp');
            $tdata['amount'] = $amounts['agentAmount'];
            Transaction::create($tdata);
        }

        // Cr refund service charges income
        if ($amounts['serviceCharges'] > 0) {
            $tdata['dr_cr'] = 2;
            $tdata['trans_acc_id'] = Config::get('constant.ticket_refund_sc');
            $tdata['amount'] = $amounts['serviceCharges'];
            Transaction::create($tdata);
        }
    }

    /**
     * Fetch ticket invoice with pax list and client details for refund form.
     */
    public function fetchInvoice($id)
    {
        $result = SaleInvoice::find($id);
        if (!$result || (int) $result->type !== 1) {
            return response()->json(['success' => false, 'message' => 'Ticket Invoice Not Found'], 404);
        }

        $pax = Ticket::where('SID', $id)->get();
        $clientAccount = TransactionAccount::find($result->ledger);
        $client = Client::where('account_id', $result->ledger)->first();

        $billAmount = (float) Ticket::where('SID', $id)->sum('receiveable');
        $paidAmount = (float) Transaction::where('SID', $id)
            ->where('trans_acc_id', $result->ledger)
            ->where('vt', 1)
            ->sum('amount');
        $remainingBalance = round($billAmount - $paidAmount, 2);

        return response()->json([
            'success' => true,
            'result' => $result,
            'pax' => $pax,
            'client' => [
                'name' => ($client ? $client->client_name : null) ?: ($clientAccount->Trans_Acc_Name ?? ''),
                'email' => $client ? ($client->email ?? '') : '',
                'phone' => $client ? ($client->mobile ?? '') : '',
                'credit_limit' => $client ? $client->credit_limit : null,
                'address' => $client ? ($client->address ?? '') : '',
            ],
            'invoice_balance' => [
                'bill_amount' => round($billAmount, 2),
                'paid_amount' => round($paidAmount, 2),
                'remaining_balance' => $remainingBalance,
            ],
        ]);
    }

    /**
     * Return one refund record for editing.
     */
    public function edit($id)
    {
        return Refund::find($id);
    }

    /**
     * Delete a refund and revert its accounting entries.
     */
    public function destroy($id)
    {
        $refund = Refund::find($id);
        if (!$refund) {
            return response()->json(['success' => 'false'], 404);
        }
        DB::beginTransaction();
        try {
            if ($refund->trans_code) {
                Transaction::where('trans_code', $refund->trans_code)->delete();
            }
            $refund->delete();
            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json([
                'success' => 'false',
                'errors' => $e->errorInfo,
            ], 400);
        }
        return response()->json(['success' => 'Refund Deleted and Transactions Reverted.']);
    }
}
