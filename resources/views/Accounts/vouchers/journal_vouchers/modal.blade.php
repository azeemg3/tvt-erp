<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Journal Voucher</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Transaction Date</label>
                            <input name="trans_date" class="form-control form-control-sm date" placeholder="Transaction Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Posting Date</label>
                            <input name="posting_date" class="form-control form-control-sm date" placeholder="Posting Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Debit A/C</label>
                            <select name="payment_to" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Accounts\TransactionAccount::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Credit A/C</label>
                            <select name="payment_from" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Accounts\TransactionAccount::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            <label>Narration</label>
                            <textarea name="narration" class="form-control form-control-sm" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control form-control-sm" placeholder="Paid Amount">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Cheque</label>
                            <input type="text" name="cheque" class="form-control form-control-sm" placeholder="e.g Cheque#">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Currency</label>
                            <select class="form-control form-control-sm select2" name="currency">
                                <option value="">Select</option>
                                {!! App\Models\Currency::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Conversion Rate</label>
                            <input type="text" name="conversion_rate" class="form-control form-control-sm" placeholder="Conversion Rate">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Ref#</label>
                            <input type="text" name="" class="form-control form-control-sm" placeholder="Refrence #">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>