<div class="modal" id="tour-modal">
    <div class="modal-dialog modal-xl">
            <input type="hidden" class="SID" name="SID" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Tour Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Inv Date*</label>
                            <input name="inv_date" class="form-control form-control-sm date inv_date" placeholder="Invice Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Due Date*</label>
                            <input name="due_date" class="form-control form-control-sm date due_date" placeholder="Due Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm payment_type">
                                {!! App\Helpers\Account::payment_type() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Receiveable/Client</label>
                            <select class="form-control form-control-sm select2" id="ledger" name="ledger">
                                <option value="">Select Receiveable</option>
                                {!! App\Models\Accounts\TransactionAccount::client_dd() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label>Remarks</label>
                            <input type="text" name="remarks" class="form-control form-control-sm remarks" placeholder="Remarks">
                        </div>
                        <!--col-->
                        <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-dark btn-flat" data-toggle="modal" data-target="#add-pax">Add Pax</button>
                        </div>
                        <div class="col-md-12">
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a onclick="get_ticket_invoice(1)" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#tour-ticket" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><i class="fa fa-ticket-alt"></i> Ticket</a>
                                        </li>
                                        <li class="nav-item">
                                            <a onclick="get_hotel_invoice()" class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#tour-hotel" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                                                <i class="fa fa-bed"></i> Hotel
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" onclick="get_visa_invoice(1)" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#tour-visa" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fa fa-globe"></i> Visa</a>

                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" onclick="get_transport_invoice(1)" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#tour-transport" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fa fa-car"></i> Transport</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#tour-other" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false"><i class="fa fa-exclamation"></i> Other</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                        @include('sales.tours.ticket')
                                        @include('sales.tours.hotel')
                                        @include('sales.tours.visa')
                                        @include('sales.tours.transport')
                                        @include('sales.tours.other')
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                </div>

            </div>
    </div>

</div>

@include('Lms.sales.modals.tour_pax_modal')