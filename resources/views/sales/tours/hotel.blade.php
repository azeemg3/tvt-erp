<div class="tab-pane fade" id="tour-hotel" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <form id="tour-hotel-form">
        <input type="hidden" name="id" value="0">
        <div class="row">
            <div class="form-group col-md-12">
                <select name="pax_name[]" class="form-control form-control-sm select2 tour_pax_list" multiple data-placeholder="Select Passengers">

                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Hotel Name</label>
                <select name="hotel" class="form-control form-control-sm select2">
                    <option value="">Search Hotel Name</option>
                    {!! App\Models\Hotel::dropdown() !!}
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Room Type</label>
                <select name="room_type" class="form-control form-control-sm select2">
                    {!! App\Helpers\CommonHelper::room_type() !!}
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Room#</label>
                <input type="text" name="room_no" class="form-control form-control-sm" placeholder="No. of room">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Check in</label>
                <input type="text" name="checkin" class="form-control form-control-sm date checkin" placeholder="Check in">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Nights</label>
                <input type="text" name="nights" onkeyup="get_next_date(this.value)" class="form-control form-control-sm" placeholder="No. of nights">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Check Out</label>
                <input type="text" name="checkout" class="form-control form-control-sm date checkout" placeholder="Check Out">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Confirmation No</label>
                <input type="text" name="confirmation" class="form-control form-control-sm" placeholder="Confirmation No">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Rate/Night*</label>
                <input type="text" name="rate_night" class="form-control form-control-sm" placeholder="Confirmation No">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Currency</label>
                <select name="currency" class="form-control form-control-sm">
                    {!! \App\Models\Currency::dropdown() !!}
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
            <div class="col-md-3">
                <div class="card card-gray rounded-0">
                    <div class="card-header rounded-0" style="padding: 5px;">
                        <h3 class="card-title">Hotel Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding: 0.5rem;">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" name="amount" class="form-control form-control-sm bf" onkeyup="hotel_cal(this)" placeholder="Enter ...">
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
            <div class="col-md-3">
                <div class="card card-gray rounded-0">
                    <div class="card-header rounded-0" style="padding: 5px;">
                        <h3 class="card-title">Payable/Vendor:</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding: 0.5rem; min-height: 230px">
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Com Rec %</label>
                                    <input type="text" class="form-control form-control-sm com_rec_p" placeholder="0.00 %">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Com Received</label>
                                    <input type="text" dirname="com_rec" class="form-control form-control-sm com_rec" name="com_rec" onkeyup="hotel_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Com Paid %</label>
                                    <input type="text" class="form-control form-control-sm com_paid_p" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Com Paid</label>
                                    <input type="text" name="com_paid" class="form-control form-control-sm com_paid" onkeyup="hotel_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>WH Air %</label>
                                    <input type="text" class="form-control form-control-sm wh_air_p" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Wh Air</label>
                                    <input type="text" name="wh_air" class="form-control form-control-sm wh_air" onkeyup="hotel_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Pst Paid</label>
                                    <input type="text" name="pst_paid" class="form-control form-control-sm pst_paid" onkeyup="hotel_cal(this)" placeholder="Enter ...">
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
            <div class="col-md-3">
                <div class="card card-gray rounded-0">
                    <div class="card-header rounded-0" style="padding: 5px;">
                        <h3 class="card-title">Receiveable/Customer:</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding: 0.5rem; min-height: 230px">
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Psf %</label>
                                    <input type="text" class="form-control form-control-sm psf_p" placeholder="0.00 %">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Psf</label>
                                    <input type="text" name="psf" class="form-control form-control-sm psf" onkeyup="hotel_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Discount %</label>
                                    <input type="text" class="form-control form-control-sm disc_p" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" name="discount" class="form-control form-control-sm disc" onkeyup="hotel_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Agent Amount</label>
                                    <input type="text" name="agent_amount" class="form-control form-control-sm agent_amount" onkeyup="hotel_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
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
            <div class="col-md-3">
                <div class="card card-gray rounded-0">
                    <div class="card-header rounded-0" style="padding: 5px;">
                        <h3 class="card-title">Net Sale:</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding: 0.5rem; min-height: 230px">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Payable</label>
                                    <input type="text" class="form-control form-control-sm payable" name="payable" placeholder="0.00 %">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Receiveable</label>
                                    <input type="text" class="form-control form-control-sm receiveable" name="receiveable" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-12">
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
            <button type="button" class="btn btn-success btn-xs" onclick="save_tour_rec('{{ url('Sale/tour_hotel_store') }}', 'tour-hotel-form', 'hotel')">Submit</button>
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
                        <th>Hotel Name</th>
                        <th>Check in</th>
                        <th>Check out</th>
                        <th>Night</th>
                        <th>Rate/Night</th>
                        <th>Receiveable</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="get_hotel_invDetails"></tbody>

                </table>
            </div>
        </div>
    </form>
</div>