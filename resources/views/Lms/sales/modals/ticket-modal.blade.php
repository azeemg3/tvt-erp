<div class="modal" id="ticket-modal">
    <div class="modal-dialog modal-xl">
        <form id="ticket-form">
            <input type="hidden" name="SID" value="0">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="leadID" value="{{ $result[0]->id }}">
            <input type="hidden" name="account_code" value="{{ $result[0]->ledger }}">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Ticket Details</h5>
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
                            <label for="exampleInputEmail1">Fourtnite Date*</label>
                            <input name="fourtnite" class="form-control form-control-sm date" placeholder="Fortnite Date">
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
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Remarks</label>
                            <input name="remarks" class="form-control form-control-sm" placeholder="Remarks">
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
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Mobile</label>
                            <input name="mobile" class="form-control form-control-sm" placeholder="Mobile">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Pax Type</label>
                            <select name="pax_type" class="form-control form-control-sm">
                                {!! App\Helpers\CommonHelper::pax_type() !!}
                            </select>
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
                            <label for="exampleInputEmail1">Ticket No#</label>
                            <input id="ticket-no" type="text" name="ticket_no" class="form-control form-control-sm ticket-no" placeholder="Ticke Number" maxlength="15">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Basic Fare</label>
                            <input type="text" name="basic_fare" class="form-control form-control-sm basic_fare" placeholder="Basic Fare">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Taxes</label>
                            <input type="text" name="total_taxes" class="form-control form-control-sm taxes" placeholder="Taxes">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Receiveable</label>
                            <input type="text" name="receiveable" class="form-control form-control-sm receiveable" placeholder="Receiveable">
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
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec('{{ route('lead_ticket.store') }}','ticket-form','ticket')">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="close_form(1)">Close</button>
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
                </div>

            </div>
        </form>
    </div>

</div>