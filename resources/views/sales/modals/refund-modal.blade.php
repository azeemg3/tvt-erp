<div class="modal" id="ticket-refund-modal">
    <div class="modal-dialog modal-xl">
        <form id="ticket-refund-form">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="rec_id" value="0">
            <input type="hidden" name="refund_to" value="1">
            <input type="hidden" name="SID" value="0" class="refund_SID">
            <input type="hidden" name="ledger" value="" class="refund_ledger">
            <input type="hidden" name="payable_id" value="" class="refund_payable_id">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Ticket Refund Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Inv No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm refund_inv_no" placeholder="Invoice No" inputmode="numeric">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Select Pax <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm refundPaxList">
                                <option value="">Select Pax</option>
                            </select>
                            <input type="hidden" name="pax_name" class="refund_pax_name">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Inv Date <span class="text-danger">*</span></label>
                            <input type="text" name="inv_date" class="form-control form-control-sm date" placeholder="Invoice Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Refund Date <span class="text-danger">*</span></label>
                            <input name="refund_date" class="form-control form-control-sm date" placeholder="Refund Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm">
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Refund Type</label>
                            <select name="refund_type" class="form-control form-control-sm">
                                <option value="0">Full Refund</option>
                                <option value="1">Partial Refund</option>
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Source</label>
                            <select name="source" class="form-control form-control-sm">
                                <option value="">Select Gds</option>
                                {!! App\Models\TicketSource::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Airline</label>
                            <select name="airline" class="form-control form-control-sm">
                                <option value="">Select Airline</option>
                                {!! App\Models\Airline::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Sector</label>
                            <input type="text" name="sector" class="form-control form-control-sm" placeholder="Sector">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Refund Sector</label>
                            <input type="text" name="refund_sector" class="form-control form-control-sm" placeholder="Refund Sector">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Ticket No#</label>
                            <input type="text" name="ticket_no" class="form-control form-control-sm" placeholder="Ticket Number" maxlength="16">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Currency</label>
                            <select name="currency" class="form-control form-control-sm currency_type">
                                {!! App\Models\Currency::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Currency Rate</label>
                            <input type="text" name="currency_rate" value="1" class="form-control form-control-sm currency_rate" placeholder="Currency Rate">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Refund Amount <span class="text-danger">*</span></label>
                            <input type="text" name="refund_amount" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm refund_amount" placeholder="Refund Amount">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Vendor/Airline Charges</label>
                            <input type="text" name="vendor_charges" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm vendor_charges" placeholder="Vendor Charges">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Service Charges</label>
                            <input type="text" name="service_charges" onkeyup="ticket_refund_cal(this)" class="form-control form-control-sm service_charges" placeholder="Service Charges">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Net Refund (To Client)</label>
                            <input type="text" name="net_refund" readonly class="form-control form-control-sm net_refund" placeholder="0.00">
                        </div>
                        <!--col-->
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control form-control-sm" style="height: 70px !important;" placeholder="Remarks"></textarea>
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
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
