<style>
    .modal {
  overflow-y:auto;
}
    </style>
<div class="tab-pane fade show active" id="tour-ticket" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <form id="tour-ticket-form">
        <input type="hidden" name="id" value="0">
        <div class="row">
            <div class="form-group col-md-12">
                <select name="pax_name[]" class="form-control form-control-sm select2 tour_pax_list" multiple="multiple" data-placeholder="Select Passengers">
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Fourtnite Date*</label>
                <input name="fourtnite" class="form-control form-control-sm date" placeholder="Fortnite Date">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Source</label>
                <select name="source" class="form-control form-control-sm">
                    <option value="">Select Gds</option>
                    {!! App\Models\TicketSource::dropdown() !!}
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Airline</label>
                <select name="airline" class="form-control form-control-sm">
                    <option value="">Select Airline</option>
                    {!! App\Models\Airline::dropdown() !!}
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Sector</label>
                <input type="text" name="sector" class="form-control form-control-sm" placeholder="Sector">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Route</label>
                <select name="route" class="form-control form-control-sm">
                    <option value="1">One Way</option>
                    <option value="2">Two Way</option>
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Departure Date</label>
                <input type="text" name="departure_date" class="form-control form-control-sm date" placeholder="Departure Date">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Return Date</label>
                <input type="text" name="return_date" class="form-control form-control-sm date" placeholder="Return Date">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">PNR#</label>
                <input type="text" name="pnr" class="form-control form-control-sm" placeholder="PNR#">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Ticket Type</label>
                <select name="ticket_type" class="form-control form-control-sm">
                    <option value="0">International</option>
                    <option value="1">Domestic</option>
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Ticket No#</label>
                <input id="ticket-no" type="text" name="ticket_no" class="form-control form-control-sm" placeholder="Ticke Number" maxlength="15">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Currency</label>
                <select name="currency" class="form-control form-control-sm currency_type">
                    {!! App\Models\Currency::dropdown() !!}
                </select>
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Currency Rate</label>
                <input type="text" name="currency_rate" class="form-control form-control-sm currency_rate" placeholder="Currency Rate">
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
                        <h3 class="card-title">Ticekt Details</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding: 0.5rem;">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Fare</label>
                                    <input type="text" name="basic_fare" onkeyup="ticket_cal(this)" class="form-control form-control-sm bf" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>SP+YI</label>
                                    <input type="text" name="sp_yi_tax" class="form-control form-control-sm sp_yi" onkeyup="cal_tax(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>RG/CVT</label>
                                    <input type="text" name="rg_cvt_tax" class="form-control form-control-sm rg_cvt" onkeyup="cal_tax(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>YQ</label>
                                    <input type="text" name="yq_tax" class="form-control form-control-sm yq" onkeyup="cal_tax(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>CED</label>
                                    <input type="text" name="ced_tax" class="form-control form-control-sm ced" onkeyup="cal_tax(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>PB/Adv YQ</label>
                                    <input type="text" name="pb_adv_tax" class="form-control form-control-sm pb_adv" onkeyup="cal_tax(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>XZ</label>
                                    <input type="text" name="xz_tax" class="form-control form-control-sm xz" onkeyup="cal_tax(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>YD</label>
                                    <input type="text" name="yd_tax" class="form-control form-control-sm yd" onkeyup="cal_tax(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>XT/UR/US</label>
                                    <input type="text" name="xt_ur_tax" class="form-control form-control-sm xt" onkeyup="cal_tax(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Other Tax</label>
                                    <input type="text" name="other_taxes" class="form-control form-control-sm other_tax" onkeyup="cal_tax(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Total Taxes</label>
                                    <input type="text" name="total_taxes" readonly="" class="form-control form-control-sm total_taxes" placeholder="0.00">
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
                    <div class="card-body" style="padding: 0.5rem; min-height: 275.92px">
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
                                    <input type="text" name="com_rec" class="form-control form-control-sm com_rec" onkeyup="ticket_cal(this)" placeholder="Enter ...">
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
                                    <input type="text" name="com_paid" class="form-control form-control-sm com_paid" onkeyup="ticket_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>WH Air %</label>
                                    <input type="text" class="form-control form-control-sm wh_air_p" onkeyup="ticket_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Wh Air</label>
                                    <input type="text" name="wh_air" class="form-control form-control-sm wh_air" onkeyup="ticket_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Pst Paid</label>
                                    <input type="text" name="pst_paid" class="form-control form-control-sm pst_paid" onkeyup="ticket_cal(this)" placeholder="Enter ...">
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
                    <div class="card-body" style="padding: 0.5rem; min-height: 275.92px">
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Psf %</label>
                                    <input type="text" class="form-control form-control-sm psf_p"  placeholder="0.00 %">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Psf</label>
                                    <input type="text" name="psf" class="form-control form-control-sm psf" onkeyup="ticket_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Discount %</label>
                                    <input type="text" class="form-control form-control-sm disc_p" onkeyup="ticket_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" name="discount" class="form-control form-control-sm disc" onkeyup="ticket_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>WH Client %</label>
                                    <input type="text" class="form-control form-control-sm wh_client_p" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Wh Client</label>
                                    <input type="text" name="wh_client" class="form-control form-control-sm wh_client" onkeyup="ticket_cal(this)" placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Agent Amount</label>
                                    <input type="text" name="agent_amount" onkeyup="ticket_cal(this)" class="form-control form-control-sm agent_amount_f" placeholder="Enter ...">
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
                    <div class="card-body" style="padding: 0.5rem; min-height: 275.92px">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Payable</label>
                                    <input type="text" name="payable" class="form-control form-control-sm payable"  placeholder="0.00">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Receiveable</label>
                                    <input type="text" name="receiveable" class="form-control form-control-sm receiveable"  placeholder="Enter ...">
                                </div>
                            </div>
                            <!--col-->
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Profit</label>
                                    <input type="text" name="profit" class="form-control form-control-sm profit"  placeholder="Enter ...">
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
            <button type="button" class="btn btn-success btn-xs" onclick="save_tour_rec('{{ url('Sale/tour_ticket_store') }}','tour-ticket-form','ticket')">Submit</button>
            <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="close_form(5)">Close</button>
        </div>
        <div class="modal-footer">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="table-active">
                        <th>#</th>
                        <th>Date</th>
                        <th>Pax Name</th>
                        <th>PNR</th>
                        <th>Ticket No.</th>
                        <th>Basic Fare</th>
                        <th>Taxes</th>
                        <th>Receiveable</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="get_ticket_invDetails"></tbody>
                </table>
            </div>
        </div>
    </form>
</div>