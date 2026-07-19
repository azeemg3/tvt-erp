<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lms\Refund;
use App\Models\Accounts\Transaction;
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
     * Store (create or update) a ticket refund and post the reversal
     * transactions against the original sale.
     *
     * Accounting entries (vt=9 Ref), all under one trans_code:
     *  Dr Vendor           refund_amount - vendor_charges  (vendor owes us back)
     *  Cr Client ledger    net_refund                      (credit note to client)
     *  Cr Refund SC income service_charges                 (our income)
     * where net_refund = refund_amount - vendor_charges - service_charges.
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
        $netRefund = $refundAmount - $vendorCharges - $serviceCharges;
        $vendorRecovery = $refundAmount - $vendorCharges;
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

        $id = $request->id;
        DB::beginTransaction();
        try {
            if ($id == '' || $id == 0) {
                $data['created_by'] = Auth::user()->id;
                $data['trans_code'] = Account::trans_code();
                $tdata['Created_By'] = Auth::user()->id;
                Refund::create($data);
                $this->post_refund_transactions($tdata, $data['trans_code'], $request->payable_id, $request->ledger, $vendorRecovery, $netRefund, $serviceCharges);
            } else {
                $refund = Refund::findOrFail($id);
                $trans_code = $refund->trans_code;
                if (empty($trans_code)) {
                    $trans_code = Account::trans_code();
                    $data['trans_code'] = $trans_code;
                }
                $data['updated_by'] = Auth::user()->id;
                $refund->update($data);
                // revert old posting then re-post with updated figures
                Transaction::where('trans_code', $trans_code)->delete();
                $tdata['Created_By'] = Auth::user()->id;
                $this->post_refund_transactions($tdata, $trans_code, $request->payable_id, $request->ledger, $vendorRecovery, $netRefund, $serviceCharges);
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
     * Create the balanced reversal entries for a ticket refund.
     */
    private function post_refund_transactions($tdata, $trans_code, $vendor_acc, $client_acc, $vendorRecovery, $netRefund, $serviceCharges)
    {
        $tdata['trans_code'] = $trans_code;
        //dr to vendor (recover from airline/vendor)
        if ($vendorRecovery > 0) {
            $tdata['dr_cr'] = 1;
            $tdata['trans_acc_id'] = $vendor_acc;
            $tdata['amount'] = $vendorRecovery;
            Transaction::create($tdata);
        }
        //cr to client (reduce receivable / refund payable to client)
        if ($netRefund > 0) {
            $tdata['dr_cr'] = 2;
            $tdata['trans_acc_id'] = $client_acc;
            $tdata['amount'] = $netRefund;
            Transaction::create($tdata);
        }
        //cr to ticket refund service charges income
        if ($serviceCharges > 0) {
            $tdata['dr_cr'] = 2;
            $tdata['trans_acc_id'] = Config::get('constant.ticket_refund_sc');
            $tdata['amount'] = $serviceCharges;
            Transaction::create($tdata);
        }
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
