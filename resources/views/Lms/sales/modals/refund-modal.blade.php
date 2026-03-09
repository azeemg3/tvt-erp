<div class="modal" id="refund-modal">
    <div class="modal-dialog modal-xl">
        <form id="refund-form">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="rec_id" value="0">
            <input type="hidden" name="leadId" value="{{ $result[0]->id }}">
            <input type="hidden" name="account_code" value="{{ $result[0]->ledger }}">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Refund Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Refund To</label>
                            <select name="refund_to" class="form-control form-control-sm refund_to">
                                {!! App\Helpers\CommonHelper::sale_types() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Inv No.</label>
                            <input type="text" name="SID" class="form-control form-control-sm inv_no" placeholder="Invoice No">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm">
                               {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Refund Type</label>
                            <select name="refund_type" class="form-control form-control-sm">
                                <option value="0">Full Refund</option>
                                <option value="1">Partial Refund</option>
                            </select>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <label>Select Pax</label>
                            <select name="pax_name" class="form-control form-control-sm paxList">
                                <option value="">Select Pax</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Inv Date*</label>
                            <input type="text" name="inv_date" class="form-control form-control-sm date" placeholder="Invoice Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Refund Date</label>
                            <input name="refund_date" class="form-control form-control-sm date" placeholder="Refund Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2 ref_source">
                            <label for="exampleInputEmail1">Source</label>
                            <select name="source" class="form-control form-control-sm">
                                <option value="">Select Gds</option>
                                {!! App\Models\TicketSource::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2 ref_airline">
                            <label for="exampleInputEmail1">Airline</label>
                            <select name="airline" class="form-control form-control-sm">
                                <option value="">Select Airline</option>
                                {!! App\Models\Airline::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2 ref_sector">
                            <label for="exampleInputEmail1">Sector</label>
                            <input type="text" name="sector" class="form-control form-control-sm" placeholder="Sector">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2 ref-sector">
                            <label for="exampleInputEmail1">Refund Sector</label>
                            <input type="text" name="refund_sector" class="form-control form-control-sm" placeholder="Refund Sector">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2 ticket_no">
                            <label for="exampleInputEmail1">Ticket No#</label>
                            <input type="text" name="ticket_no" class="form-control form-control-sm ticket-no" placeholder="Ticke Number" maxlength="15">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Refund Amount</label>
                            <input type="text" name="refund_amount" class="form-control form-control-sm" placeholder="Refund Amount">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Service Charges</label>
                            <input type="text" name="service_charges" class="form-control form-control-sm" placeholder="Service Charges">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency</label>
                            <select name="currency" class="form-control form-control-sm currency_type">
                                {!! App\Models\Currency::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency Rate</label>
                            <input type="text" name="currency_rate" class="form-control form-control-sm currency_rate" placeholder="Currency Rate">
                        </div>
                        <!--col-->
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Remarks</label>
                            <textarea name="remarks" class="form-control form-control-sm" style="height: 70px !important;" placeholder="Remarks"></textarea>
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_refund()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="get_refunds(1)">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>