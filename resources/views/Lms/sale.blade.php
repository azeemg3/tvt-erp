<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    @can('lead_ticket_view')
                    <li class="nav-item">
                        <a onclick="get_ticket_invoice(1)" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#ticket" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><i class="fa fa-ticket-alt"></i> Ticket</a>
                    </li>
                    @endcan
                    @can('lead_hotel_view')
                    <li class="nav-item">
                        <a onclick="get_hotel_invoice()" class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#hotel" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                            <i class="fa fa-bed"></i> Hotel
                        </a>
                    </li>
                        @endcan
                    @can('lead_visa_view')
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_visa_invoice(1)" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#visa" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fa fa-globe"></i> Visa</a>

                    </li>
                        @endcan
                        @can('lead_transport_view')
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_transport_invoice(1)" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#transport" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fa fa-car"></i> Transport</a>
                    </li>
                        @endcan
                        @can('lead_tour_view')
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_tour_invoice(1)" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#tour" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false"><i class="fa fa-kaaba"></i> Tour/Umrah</a>
                    </li>
                        @endcan
                    @can('lead_other_view')
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_other_invoice(1)" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#other" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false"><i class="fa fa-exclamation"></i> Other</a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_refunds(1)" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#refund" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false"><i class="fa fa-undo-alt"></i> Refund</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" onclick="get_receipts(1)"  id="custom-tabs-one-settings-tab" data-toggle="pill" href="#receipt" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false"><i class="fa fa-receipt"></i> Receipt Voucher</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" onclick="get_client_doc(1)"  id="custom-tabs-one-settings-tab" data-toggle="pill" href="#documents" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">
                        <i class="fa fa-paperclip"></i> Client  Documents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_pcr_invoice(1)"  id="custom-tabs-one-settings-tab" data-toggle="pill" href="#pcr_test" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">
                            <i class="fa fa-syringe"></i> PCR Test</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    @include('Lms.sales.ticket')
                    @include('Lms.sales.hotel')
                    @include('Lms.sales.visa')
                    @include('Lms.sales.transport')
                    @include('Lms.sales.tour')
                    @include('Lms.sales.other')
                    @include('Lms.sales.refund')
                    @include('Lms.sales.receipt')
                    @include('Lms.sales.client_documents')
                    @include('Lms.sales.pcr_test')
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    </div>
    <!-- /.col -->
<!-- /.row -->
@include('Lms.sales.modals.ticket-modal')
@include('Lms.sales.modals.hotel-modal')
@include('Lms.sales.modals.visa-modal')
@include('Lms.sales.modals.transport-modal')
@include('Lms.sales.modals.tour-modal')
@include('Lms.sales.modals.other-modal')
@include('Lms.sales.modals.refund-modal')
@include('Lms.sales.modals.receipt-modal')
@include('Lms.sales.modals.document-modal')
@include('Lms.sales.modals.pcr-modal')