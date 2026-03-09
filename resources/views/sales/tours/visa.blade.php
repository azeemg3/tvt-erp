<div class="tab-pane fade" id="tour-visa" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <form id="tour-visa-form">
        <input type="hidden" name="id" value="0">
        <div class="row">
            <div class="form-group col-md-12">
                <select name="pax_name[]" class="form-control form-control-sm select2 tour_pax_list" multiple></select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Visa Type</label>
                <select name="visa_type" class="form-control form-control-sm select2">
                    {!! App\Helpers\CommonHelper::visa_type() !!}
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label>Visa No.</label>
                <input name="visa_no" type="text" class="form-control form-control-sm" placeholder="Visa Number">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Visa Country</label>
                <select name="visa_country" class="form-control form-control-sm select2">
                    {!! App\Models\Country::dropdown() !!}
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label>Visa Rate</label>
                <input type="text" name="visa_rate" class="form-control form-control-sm bf" onkeyup="visa_cal(this)" placeholder="Visa Rate">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Currency</label>
                <select name="currency" class="form-control form-control-sm select2">
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
            <div class="form-group col-md-2">
                <label>Vendor/Payable</label>
                <select class="form-control form-control-sm select2" name="payable_id">
                    <option value="">Select Payable</option>
                    {!! App\Models\Accounts\TransactionAccount::vendor_dd() !!}
                </select>
            </div>
            <!--col-->
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-gray rounded-0">
                    <div class="card-header rounded-0" style="padding: 5px;">
                        <h3 class="card-title">Receiveable/Customer:</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding: 0.5rem;">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Psf</label>
                                    <input name="psf" type="text" class="form-control form-control-sm psf" onkeyup="visa_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input name="discount" type="text" class="form-control form-control-sm dis" onkeyup="visa_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Agent Amount</label>
                                    <input type="text" name="agent_amount" class="form-control form-control-sm agent_amount" onkeyup="visa_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Agent:</label>
                                    <select class="form-control form-control-sm select2" name="agent_id">
                                        <option value="">Select Agent</option>
                                        {!! App\Models\Accounts\TransactionAccount::dropdown() !!}
                                    </select>
                                </div>
                            </div>
                            <!--col-->
                        </div>
                        <!--row-->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--col-->
            <div class="col-md-6">
                <div class="card card-gray rounded-0">
                    <div class="card-header rounded-0" style="padding: 5px;">
                        <h3 class="card-title">Net Sale:</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding: 0.5rem;">
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Payable</label>
                                    <input type="text" name="payable" class="form-control form-control-sm payable" placeholder="0.00 %">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Receiveable</label>
                                    <input type="text" class="form-control form-control-sm receiveable" name="receiveable" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Profit</label>
                                    <input type="text" class="form-control form-control-sm profit" name="profit" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                        </div>
                        <!--row-->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--col-->
        </div>
        <!--row-->
        <!-- Modal footer -->
        <div class="clearfix"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn-xs" onclick="save_tour_rec('{{ url('Sale/tour_visa_store') }}', 'tour-visa-form', 'visa')">Submit</button>
            <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="close_form(5)">Close</button>
        </div>
        <div class="modal-footer">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="table-active">
                        <th>#</th>
                        <th>passport</th>
                        <th>Pax Name</th>
                        <th>Visa No</th>
                        <th>Visa Type</th>
                        <th>Visa Country</th>
                        <th>Receiveable</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="get_visa_invDetails"></tbody>
                </table>
            </div>
        </div>
    </form>
</div>