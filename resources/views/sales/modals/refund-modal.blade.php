<div class="modal" id="ticket-refund-modal">
    <div class="modal-dialog modal-xl">
        <form id="ticket-refund-form">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="rec_id" value="0">
            <input type="hidden" name="refund_to" value="1">
            <input type="hidden" name="SID" value="0" class="refund_SID">
            <input type="hidden" name="ledger" value="" class="refund_ledger">
            <input type="hidden" name="payable_id" value="" class="refund_payable_id">
            <input type="hidden" name="pax_name" class="refund_pax_name">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Ticket Refund Details</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Inv No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm refund_inv_no" placeholder="Invoice No" inputmode="numeric">
                        </div>
                        <div class="col-md-10 refund-client-info d-none">
                            <div class="callout callout-info py-2 mb-0">
                                <div class="row">
                                    <div class="col-md-3"><strong>Client:</strong> <span class="refund_client_name">-</span></div>
                                    <div class="col-md-3"><strong>Phone:</strong> <span class="refund_client_phone">-</span></div>
                                    <div class="col-md-3"><strong>Email:</strong> <span class="refund_client_email">-</span></div>
                                    <div class="col-md-3"><strong>Remaining Balance:</strong> <span class="refund_inv_balance text-danger font-weight-bold">-</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Select Pax <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm refundPaxList">
                                <option value="">Select Pax</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Inv Date <span class="text-danger">*</span></label>
                            <input type="text" name="inv_date" class="form-control form-control-sm date" placeholder="Invoice Date">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Refund Date <span class="text-danger">*</span></label>
                            <input name="refund_date" class="form-control form-control-sm date" placeholder="Refund Date">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm">
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Refund Type</label>
                            <select name="refund_type" class="form-control form-control-sm">
                                <option value="0">Full Refund</option>
                                <option value="1">Partial Refund</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Source</label>
                            <select name="source" class="form-control form-control-sm">
                                <option value="">Select Gds</option>
                                {!! App\Models\TicketSource::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Airline</label>
                            <select name="airline" class="form-control form-control-sm">
                                <option value="">Select Airline</option>
                                {!! App\Models\Airline::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Sector</label>
                            <input type="text" name="sector" class="form-control form-control-sm" placeholder="Sector">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Refund Sector</label>
                            <input type="text" name="refund_sector" class="form-control form-control-sm" placeholder="Refund Sector">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Ticket No#</label>
                            <input type="text" name="ticket_no" class="form-control form-control-sm ticket-no" placeholder="Ticket Number" maxlength="16">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Currency</label>
                            <select name="currency" class="form-control form-control-sm currency_type">
                                {!! App\Models\Currency::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Currency Rate</label>
                            <input type="text" name="currency_rate" value="1" class="form-control form-control-sm currency_rate" placeholder="Currency Rate">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Remarks</label>
                            <input name="remarks" class="form-control form-control-sm" placeholder="Remarks">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-gray rounded-0">
                                <div class="card-header rounded-0" style="padding: 5px;">
                                    <h3 class="card-title">Ticket Details</h3>
                                </div>
                                <div class="card-body" style="padding: 0.5rem;">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Fare</label>
                                                <input type="text" name="basic_fare" onkeyup="refund_cal_tax(this)" class="form-control form-control-sm bf" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>SP+YI</label>
                                                <input type="text" name="sp_yi_tax" class="form-control form-control-sm sp_yi" onkeyup="refund_cal_tax(this)" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>RG/CVT</label>
                                                <input type="text" name="rg_cvt_tax" class="form-control form-control-sm rg_cvt" onkeyup="refund_cal_tax(this)" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>YQ</label>
                                                <input type="text" name="yq_tax" class="form-control form-control-sm yq" onkeyup="refund_cal_tax(this)" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>CED</label>
                                                <input type="text" name="ced_tax" class="form-control form-control-sm ced" onkeyup="refund_cal_tax(this)" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>PB/Adv YQ</label>
                                                <input type="text" name="pb_adv_tax" class="form-control form-control-sm pb_adv" onkeyup="refund_cal_tax(this)" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>XZ</label>
                                                <input type="text" name="xz_tax" class="form-control form-control-sm xz" onkeyup="refund_cal_tax(this)" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>YD</label>
                                                <input type="text" name="yd_tax" class="form-control form-control-sm yd" onkeyup="refund_cal_tax(this)" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>XT/UR/US</label>
                                                <input type="text" name="xt_ur_tax" class="form-control form-control-sm xt" onkeyup="refund_cal_tax(this)" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Other Tax</label>
                                                <input type="text" name="other_taxes" class="form-control form-control-sm other_tax" onkeyup="refund_cal_tax(this)" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Total Taxes</label>
                                                <input type="text" name="total_taxes" readonly class="form-control form-control-sm total_taxes" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-gray rounded-0">
                                <div class="card-header rounded-0" style="padding: 5px;">
                                    <h3 class="card-title">Payable/Vendor</h3>
                                </div>
                                <div class="card-body" style="padding: 0.5rem; min-height: 327.91px">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Com Rec %</label>
                                                <input type="text" class="form-control form-control-sm com_rec_p" placeholder="0.00 %">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Com Received</label>
                                                <input type="text" name="com_rec" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm com_rec" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Com Paid %</label>
                                                <input type="text" class="form-control form-control-sm com_paid_p" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Com Paid</label>
                                                <input type="text" name="com_paid" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm com_paid" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>WH Air %</label>
                                                <input type="text" class="form-control form-control-sm wh_air_p" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Wh Air</label>
                                                <input type="text" name="wh_air" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm wh_air" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Pst Paid</label>
                                                <input type="text" name="pst_paid" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm pst_paid" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Vendor/Airline Charges</label>
                                                <input type="text" name="vendor_charges" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm vendor_charges" placeholder="Vendor Charges">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-gray rounded-0">
                                <div class="card-header rounded-0" style="padding: 5px;">
                                    <h3 class="card-title">Receivable/Customer</h3>
                                </div>
                                <div class="card-body" style="padding: 0.5rem; min-height: 327.91px">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Psf %</label>
                                                <input type="text" class="form-control form-control-sm psf_p" placeholder="0.00 %">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Psf</label>
                                                <input type="text" name="psf" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm psf" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Discount %</label>
                                                <input type="text" class="form-control form-control-sm disc_p" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Discount</label>
                                                <input type="text" name="discount" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm disc" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>WH Client %</label>
                                                <input type="text" class="form-control form-control-sm wh_client_p" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label>Wh Client</label>
                                                <input type="text" name="wh_client" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm wh_client" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Agent Amount</label>
                                                <input type="text" name="agent_amount" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm agent_amount_f" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Agent</label>
                                                <select name="agent_id" class="form-control form-control-sm agent_f">
                                                    <option value="">Select Agent</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Service Charges</label>
                                                <input type="text" name="service_charges" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm service_charges" placeholder="Service Charges">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-gray rounded-0">
                                <div class="card-header rounded-0" style="padding: 5px;">
                                    <h3 class="card-title">Net Refund</h3>
                                </div>
                                <div class="card-body" style="padding: 0.5rem; min-height: 327.91px">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Vendor Recovery</label>
                                                <input type="text" name="payable" readonly class="form-control form-control-sm payable" placeholder="0.00">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Refund Amount <span class="text-danger">*</span></label>
                                                <input type="text" name="refund_amount" readonly class="form-control form-control-sm refund_amount" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Net Refund (To Client)</label>
                                                <input type="text" name="net_refund" readonly class="form-control form-control-sm net_refund" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_ticket_refund()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="get_ticket_refunds(1)">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
