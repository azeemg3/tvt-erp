<div class="tab-pane fade" id="tour-transport" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <form id="tour-transport-form">
        <input type="hidden" name="id" value="0">
        <div class="row">
            <div class="form-group col-md-12">
                <select name="pax_name[]" class="form-control form-control-sm select2 tour_pax_list" multiple data-placeholder="Select Passengers">
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Vehicle Type</label>
                <select name="vehicle_type" class="form-control form-control-sm select2">
                    {!! App\Helpers\CommonHelper::vehicle_types() !!}
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label>From Date</label>
                <input type="text" name="from_date" class="form-control form-control-sm date" placeholder="From Date">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label>To Date</label>
                <input type="text" name="to_date" class="form-control form-control-sm date" placeholder="To Date">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label>Rate</label>
                <input type="text" name="rate" onkeyup="trans_cal(this)" class="form-control form-control-sm bf" placeholder="Rate">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Currency</label>
                <select name="currency" class="form-control form-control-sm">
                    <option value="">Pkr</option>
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
                                    <input type="text" name="psf" onkeyup="trans_cal(this)" class="form-control form-control-sm psf" onkeyup="trans_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" name="discount" onkeyup="trans_cal(this)" class="form-control form-control-sm dis" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Agent Amount</label>
                                    <input type="text" name="agent_amount" onkeyup="trans_cal(this)" class="form-control form-control-sm agent_amount" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Agent:</label>
                                    <select class="form-control form-control-sm select2" name="agent_id">
                                        <option value="">Select Agent</option>
                                        {!! App\Models\Accounts\TransactionAccount::client_dd() !!}
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
                                    <input type="text" name="payable" class="form-control form-control-sm payable" onkeyup="trans_cal(this)" placeholder="0.00">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Receiveable</label>
                                    <input type="text" name="receiveable" class="form-control form-control-sm receiveable" placeholder="Enter ...">
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
            <button type="button" class="btn btn-success btn-xs" onclick="save_tour_rec('{{ url('Sale/tour_transport_store') }}', 'tour-transport-form', 'transport')">Submit</button>
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
                        <th>Pax Type</th>
                        <th>Vehicle Type</th>
                        <th>Receiveable</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="get_transport_invDetails"></tbody>
                </table>
            </div>
        </div>
    </form>
</div>