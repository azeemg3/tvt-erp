<div class="modal" id="hotel-modal">
    <div class="modal-dialog modal-xl">
        <form id="hotel-form">
            <input type="hidden" name="SID" value="0">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Hotel Details</h5>
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
                                {!! App\Helpers\CommonHelper::pax_type() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Select Receiveable</label>
                                <select name="ledger" class="form-control form-control-sm select2">
                                    <option value="">Select Receiveable</option>
                                    {!! App\Models\Accounts\TransactionAccount::client_dd() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label>Remarks</label>
                            <input type="text" name="remarks" class="form-control form-control-sm" placeholder="Remarks">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Passport*</label>
                            <input name="passport" class="form-control form-control-sm" placeholder="Passport">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Pax Name</label>
                            <input name="pax_name" class="form-control form-control-sm" placeholder="Passenger Name">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Pax Mobile</label>
                            <input name="mobile" class="form-control form-control-sm" placeholder="Passenger Name">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Pax Type</label>
                            <select  name="pax_type" class="form-control form-control-sm">
                                {!! App\Helpers\CommonHelper::pax_type() !!}
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
                            <input type="text" name="nights" onkeyup="get_next_date(this.value)" class="form-control form-control-sm total_nights" placeholder="No. of nights">
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
                            <input type="text" name="rate_night" class="form-control form-control-sm rate_night" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="col-sm-2">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Select Vendor</label>
                                <select name="payable_id" class="form-control form-control-sm select2">
                                    <option value="0">Select Payable</option>
                                    {!! App\Models\Accounts\TransactionAccount::vendor_dd() !!}
                                </select>
                            </div>
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
                    </div>
                    <!--row-->
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
                                                <input type="text" name="amount" class="form-control form-control-sm bf" placeholder="Enter ..." onkeyup="hotel_cal(this)">
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
                                                <input type="text" onkeyup="hotel_cal(this)" name="com_rec" class="form-control form-control-sm com_rec" placeholder="Enter ...">
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
                                                <input type="text" onkeyup="hotel_cal(this)" name="com_paid" class="form-control form-control-sm com_paid" placeholder="Enter ...">
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
                                                <input type="text" name="wh_air" onkeyup="hotel_cal(this)" class="form-control form-control-sm wh_air" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <!--col-->
                                        <div class="col-sm-12">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Pst Paid</label>
                                                <input type="text" name="pst_paid" onkeyup="hotel_cal(this)" class="form-control form-control-sm pst_paid" placeholder="Enter ...">
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
                                                <input type="text" onkeyup="hotel_cal(this)" name="psf" class="form-control form-control-sm psf" placeholder="Enter ...">
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
                                                <input type="text" name="discount" onkeyup="hotel_cal(this)" class="form-control form-control-sm disc" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <!--col-->
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Agent Amount</label>
                                                <input type="text" name="agent_amount" onkeyup="hotel_cal(this)" class="form-control form-control-sm agent_amount" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <!--col-->
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Agent:</label>
                                                <select name="agent_id" class="form-control form-control-sm select2">
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
                                                <input name="payable" type="text" class="form-control form-control-sm payable" placeholder="0.00 %">
                                            </div>
                                        </div>
                                        <!--col-->
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Receiveable</label>
                                                <input type="text" name="receiveable" class="form-control form-control-sm receiveable" placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <!--col-->
                                        <div class="col-sm-12">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Profit</label>
                                                <input type="text" name="profit" class="form-control form-control-sm profit" placeholder="Enter ...">
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
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec('{{ route('acc_hotel.store') }}', 'hotel-form', 'hotel')">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="close_form(2)">Close</button>
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
                </div>

            </div>
        </form>
    </div>

</div>