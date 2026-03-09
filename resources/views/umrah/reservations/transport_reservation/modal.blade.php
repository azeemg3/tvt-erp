<div class="modal" id="transport-reservation">
    <div class="modal-dialog modal-xl">
        <form id="trans-reservation-form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Transport BRN</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>#BRN<span class="text-danger">*</span></label>
                                <input type="text" name="brn" class="form-control form-control-sm" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Booking Date<span class="text-danger">*</span></label>
                                <input type="text" name="booking_date" class="form-control form-control-sm date" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Transport Co.</label>
                                <select name="transport_co" class="form-control form-control-sm select2" id="fetch_trans_company" onchange="add_transport_compnay(this.value)">
                                    <option value="">--Select--</option>
                                    <option value="new">Add New</option>
                                    {!! App\Models\Umrah\TransportCompany::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Vehicle Type<span class="text-danger">*</span></label>
                                <select name="vehicle_type" class="form-control form-control-sm select2">
                                    <option value="">--Select--</option>
                                    {!! App\Helpers\CommonHelper::vehicle_types() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cycle</label>
                                <select name="cycle" class="form-control form-control-sm">
                                    {!! App\Models\Umrah\TransportCycle::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Arrival Date</label>
                                <input type="text" name="arrival_date" class="form-control form-control-sm date" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Total Capacity<span class="text-danger">*</span></label>
                                <input type="text" name="total_capacity" class="form-control form-control-sm" placeholder="Enter Capacity">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Purchsed By</label>
                                <select name="purchased_by" class="form-control form-control-sm select2">
                                    <option value="">--Select--</option>
                                    {!! App\Models\Accounts\TransactionAccount::vendor_dd() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Currency</label>
                                <select name="currency" class="form-control form-control-sm select2">
                                    <option value="">--Currency--</option>
                                    {!! \App\Models\Currency::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Currency Rate</label>
                                <input type="text" name="currency_rate" class="form-control form-control-sm" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Purchase Rate</label>
                                <input type="text" name="purchase_rate" class="form-control form-control-sm" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sector From</label>
                                <select name="from_city[]" class="form-control form-control-sm select2">
                                    <option value="">From City</option>
                                    {!! App\Models\UmrahTransportCity::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">To City</label>
                                <select name="to_city[]" class="form-control form-control-sm select2">
                                    <option value="">Select Sector</option>
                                    {!! App\Models\UmrahTransportCity::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <label>Date</label>
                            <input type="text" name="sector_date[]" class="form-control form-control-sm date" placeholder="Date">
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <label>Time</label>
                            <input type="time" name="sector_time[]" class="form-control form-control-sm">
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label style="visibility: hidden" for="exampleInputEmail1">Sector From</label>
                                <button type="button" onclick="more_transport_sector()" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <div class="more-tr-sectors"></div>
                    <hr style="margin: 0px 0px 0px 0px !important;">
                    <div class="more-item"></div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Save</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>