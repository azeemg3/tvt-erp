<div class="modal" id="pcr-modal">
    <div class="modal-dialog modal-xl">
        <form id="pcr-form">
            <input type="hidden" name="SID" value="0">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="leadId" value="{{ $result[0]->id }}">
            <input type="hidden" name="account_code" value="{{ $result[0]->ledger }}">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">PCR Test Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Inv Date*</label>
                            <input name="inv_date" class="form-control form-control-sm date" placeholder="Invice Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Due Date*</label>
                            <input name="due_date" class="form-control form-control-sm date" placeholder="Due Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm">
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-6">
                            <label>Remarks</label>
                            <input type="text" name="remarks" class="form-control form-control-sm" placeholder="Remarks">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Payable/Vendor</label>
                            <select name="payable_id" class="form-control form-control-sm select2">
                                {!! App\Models\Accounts\TransactionAccount::vendor_dd() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Test Date*</label>
                            <input name="test_date" class="form-control form-control-sm date" placeholder="Test Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Pax Name</label>
                            <input name="pax_name" class="form-control form-control-sm" placeholder="Passenger Name">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Pax Type</label>
                            <select name="pax_type" class="form-control form-control-sm">
                                {!! App\Helpers\CommonHelper::pax_type() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Lab Name</label>
                            <input type="text" name="lab_name" class="form-control form-control-sm" placeholder="Lab Name">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Airline</label>
                            <select name="airline_id" class="form-control form-control-sm select2">
                                <option value="">Select Airline</option>
                                {!! App\Models\Airline::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Purchase Price</label>
                            <input type="text" name="payable" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Sale Price</label>
                            <input type="text" name="rate" class="form-control form-control-sm basic_fare" placeholder="Rate">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Discount</label>
                            <input type="text" name="discount" class="form-control form-control-sm discount" placeholder="Rate">
                        </div>
                        <!--col--><div class="form-group col-md-2">
                            <label>Receiveable</label>
                            <input type="text" name="receiveable" class="receiveable form-control form-control-sm" placeholder="Rate">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency</label>
                            <select name="currency_id" class="form-control form-control-sm">
                                <option value="">Pkr</option>
                                {!! App\Models\Currency::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency Rate</label>
                            <input type="text" name="currency_rate" class="form-control form-control-sm" placeholder="Currency Rate">
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec('{{ route('lead_pcr_test.store') }}','pcr-form','pcr')">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="close_form(6)">Close</button>
                    </div>
                    <div class="modal-footer">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="table-active">
                                    <th>#</th>
                                    <th>Pax Name</th>
                                    <th>Pax Type</th>
                                    <th>Lab Name</th>
                                    <th>Receiveable</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="get_pcr_invDetails"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>