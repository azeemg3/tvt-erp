<div class="modal" id="transport-modal">
    <div class="modal-dialog modal-xl">
        <form id="transport-form">
            <input type="hidden" name="SID" value="0">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="leadID" value="<?php echo e($result[0]->id); ?>">
            <input type="hidden" name="account_code" value="<?php echo e($result[0]->ledger); ?>">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Transport Details</h5>
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
                                <?php echo App\Helpers\Account::payment_type(); ?>

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
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Pax Type</label>
                            <select name="pax_type" class="form-control form-control-sm">
                                <?php echo App\Helpers\CommonHelper::pax_type(); ?>

                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Vehicle Type</label>
                            <select name="vehicle_type" class="form-control form-control-sm select2">
                                <?php echo App\Helpers\CommonHelper::vehicle_types(); ?>

                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>From Date</label>
                            <input type="text" name="from_date" class="form-control form-control-sm date" placeholder="From Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>To Date</label>
                            <input type="text" name="to_date" class="form-control form-control-sm date" placeholder="To Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Rate</label>
                            <input type="text" name="receiveable" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency</label>
                            <select name="currency" class="form-control form-control-sm">
                                <option value="">Pkr</option>
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
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec('<?php echo e(route('lead_transport.store')); ?>','transport-form','transport')">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="close_form(4)">Close</button>
                    </div>
                    <div class="modal-footer">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="table-active">
                                    <th>#</th>
                                    <th>passport</th>
                                    <th>Pax Name</th>
                                    <th>Pax Type</th>
                                    <th>Vehicle Type</th>
                                    <th>Receiveable</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="get_transport_invDetails"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/Lms/sales/modals/transport-modal.blade.php ENDPATH**/ ?>