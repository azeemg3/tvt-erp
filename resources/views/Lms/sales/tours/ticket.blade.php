<div class="tab-pane fade show active" id="tour-ticket" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <form id="tour-ticket-form">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="account_code" value="{{ $result[0]->ledger }}">
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
                <label for="exampleInputEmail1">Ticket No#</label>
                <input id="ticket-no" type="text" name="ticket_no" class="form-control form-control-sm" placeholder="Ticke Number" maxlength="15">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Basic Fare</label>
                <input type="text" name="basic_fare" class="form-control form-control-sm basic_fare" placeholder="Basic Fare">
            </div>
            <!--col-->
            <div class="form-group col-md-2">
                <label for="exampleInputEmail1">Taxes</label>
                <input type="text" name="taxes" class="form-control form-control-sm taxes" placeholder="Taxes">
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
            <button type="button" class="btn btn-success btn-xs" onclick="save_tour_rec('{{ url('lms/tour_ticket_store') }}','tour-ticket-form','ticket')">Submit</button>
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