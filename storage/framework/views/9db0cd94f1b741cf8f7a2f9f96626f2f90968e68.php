<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead_ticket_view')): ?>
                    <li class="nav-item">
                        <a onclick="get_ticket_invoice(1)" class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#ticket" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><i class="fa fa-ticket-alt"></i> Ticket</a>
                    </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead_hotel_view')): ?>
                    <li class="nav-item">
                        <a onclick="get_hotel_invoice()" class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#hotel" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">
                            <i class="fa fa-bed"></i> Hotel
                        </a>
                    </li>
                        <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead_visa_view')): ?>
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_visa_invoice(1)" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#visa" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fa fa-globe"></i> Visa</a>

                    </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead_transport_view')): ?>
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_transport_invoice(1)" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#transport" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fa fa-car"></i> Transport</a>
                    </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead_tour_view')): ?>
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_tour_invoice(1)" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#tour" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false"><i class="fa fa-kaaba"></i> Tour/Umrah</a>
                    </li>
                        <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lead_other_view')): ?>
                    <li class="nav-item">
                        <a class="nav-link" onclick="get_other_invoice(1)" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#other" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false"><i class="fa fa-exclamation"></i> Other</a>
                    </li>
                    <?php endif; ?>
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
                    <?php echo $__env->make('Lms.sales.ticket', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('Lms.sales.hotel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('Lms.sales.visa', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('Lms.sales.transport', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('Lms.sales.tour', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('Lms.sales.other', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('Lms.sales.refund', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('Lms.sales.receipt', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('Lms.sales.client_documents', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('Lms.sales.pcr_test', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    </div>
    <!-- /.col -->
<!-- /.row -->
<?php echo $__env->make('Lms.sales.modals.ticket-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Lms.sales.modals.hotel-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Lms.sales.modals.visa-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Lms.sales.modals.transport-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Lms.sales.modals.tour-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Lms.sales.modals.other-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Lms.sales.modals.refund-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Lms.sales.modals.receipt-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Lms.sales.modals.document-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Lms.sales.modals.pcr-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/Lms/sale.blade.php ENDPATH**/ ?>