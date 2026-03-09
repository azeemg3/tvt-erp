<style>
    .form-group{
        margin-bottom: 0.3rem !important;
    }
</style>
<div class="modal" id="new">
    <div class="modal-dialog modal-xl">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Visa Rate</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Visa Type</label>
                            <select name="visa_type" class="form-control form-control-sm">
                                <option value="">Select</option>
                                {!! App\Helpers\CommonHelper::visa_type() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Source</label>
                            <select name="source" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Accounts\TransactionAccount::vendor_dd() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency</label>
                            <select name="currency_id" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Currency::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency Conversion Rate</label>
                            <input type="text" name="currency_rate" class="form-control form-control-sm" placeholder="Currency Rate">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Validity From</label>
                            <input type="text" name="validity_from" class="form-control form-control-sm date" placeholder="Validity From">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Validity To</label>
                            <input type="text" name="validity_to" class="form-control form-control-sm date" placeholder="Validity To">
                        </div>
                    </div>
                    <kbd>Adult</kbd>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Purchase</label>
                            <input onkeyup="calculate_rate(this)" type="text" name="adult['purchae']" class="form-control form-control-sm purchase_price Apurchase_price" placeholder="Visa Purchase">
                        </div>
                        <div class="form-group col-md-1">
                            <label>Sale Tax</label>
                            <input type="text" name="adult['sale_tax']" class="form-control form-control-sm sale_tax" onkeyup="calculate_rate(this)" placeholder="Sale Tax">
                        </div>
                        <div class="form-group col-md-1">
                            <label>VAT</label>
                            <input type="text" name="adult['vat']" class="form-control form-control-sm vat" onkeyup="calculate_rate(this)" placeholder="Wat">
                        </div>
                        <div class="form-group col-md-1">
                            <label>WH Tax</label>
                            <input type="text" name="adult['wh_tax']" class="form-control form-control-sm wh" onkeyup="calculate_rate(this)" placeholder="WH Tax">
                        </div>
                        <div class="form-group col-md-1">
                            <label style="font-size: 12px">Other Charges</label>
                            <input type="text" name="adult['other_charges']" class="form-control form-control-sm oc" onkeyup="calculate_rate(this)" placeholder="Other Charges">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Net Sale</label>
                            <input type="text" name="adult['net_sale']" class="form-control form-control-sm net_sale" placeholder="Net Sale" readonly>
                        </div>
                    </div>
                    <!--row-->
                    <kbd>Child</kbd>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <input type="text" name="child['purchase']" class="form-control form-control-sm purchase_price Cpurchase_price" onkeyup="calculate_rate(this)" placeholder="Visa Purchase">
                        </div>
                        <div class="form-group col-md-1">
                            <input type="text" name="child['sale_tax']" class="form-control form-control-sm sale_tax" onkeyup="calculate_rate(this)" placeholder="Sale Tax">
                        </div>
                        <div class="form-group col-md-1">
                            <input type="text" name="child['vat']" class="form-control form-control-sm vat" onkeyup="calculate_rate(this)" placeholder="VAT">
                        </div>
                        <div class="form-group col-md-1">
                            <input type="text" name="child['wh_tax']" class="form-control form-control-sm wh" onkeyup="calculate_rate(this)" placeholder="WH Tax">
                        </div>
                        <div class="form-group col-md-1">
                            <input type="text" name="child['other_charges']" class="form-control form-control-sm oc" onkeyup="calculate_rate(this)" placeholder="Other Charges">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" name="child['net_sale']" class="form-control form-control-sm net_sale" placeholder="Net Sale" readonly>
                        </div>
                    </div>
                    <!--row-->
                    <kbd>Infant</kbd>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <input type="text" name="infant['purchase']" class="form-control form-control-sm Ipurchase_price purchase_price" onkeyup="calculate_rate(this)" placeholder="Visa Purchase">
                        </div>
                        <div class="form-group col-md-1">
                            <input type="text" name="infant['sale_tax']" class="form-control form-control-sm sale_tax" onkeyup="calculate_rate(this)" placeholder="Sale Tax">
                        </div>
                        <div class="form-group col-md-1">
                            <input type="text" name="infant['vat']" class="form-control form-control-sm vat" onkeyup="calculate_rate(this)" placeholder="VAT">
                        </div>
                        <div class="form-group col-md-1">
                            <input type="text" name="infant['wh_tax']" class="form-control form-control-sm wh" onkeyup="calculate_rate(this)" placeholder="WH Tax">
                        </div>
                        <div class="form-group col-md-1">
                            <input type="text" name="infant['other_charges']" class="form-control form-control-sm oc" onkeyup="calculate_rate(this)" placeholder="Other Charges">
                        </div>
                        <div class="form-group col-md-2">
                            <input type="text" name="infant['net_sale']" class="form-control form-control-sm net_sale" placeholder="Net Sale" readonly>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group form-check col-md-12">
                            <h6>Assign to Agent:</h6>
                        </div>
                    </div>
                    <!--row-->
                    <div class="more-item"></div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-xs" id="approve-first" style="display: none" onclick="approved_rate()">Approve First</button>
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>