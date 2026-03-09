<div class="modal" id="hotel-modal">
    <div class="modal-dialog modal-xl">
        <form id="hotel-form">
            <input type="hidden" name="SID" value="0">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="leadID" value="{{ $result[0]->id }}">
            <input type="hidden" name="account_code" value="{{ $result[0]->ledger }}">
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
                        <div class="form-group col-md-6">
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
                            <label for="exampleInputEmail1">Receiveable</label>
                            <input type="text" name="receiveable" class="form-control form-control-sm" placeholder="Receiveable">
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
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec('{{ route('lead_hotel.store') }}', 'hotel-form', 'hotel')">Submit</button>
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