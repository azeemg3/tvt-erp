<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Ground Handle Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Company Name</label>
                            <input type="text" name="comp_name" class="form-control form-control-sm" calculate_rate(this) onkeyup="calculate_rate(this)" placeholder="Enter...">
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
                            <label for="exampleInputEmail1">Currency Rate</label>
                            <input name="currency_rate" type="text" class="form-control form-control-sm" placeholder="Curr Rate">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Rate</label>
                            <input type="text" name="rate" class="form-control form-control-sm">
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Contact Details:</label>
                            <textarea class="form-control textarea" name="contact_details"></textarea>
                        </div>
                    </div>
                    <!--row-->
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