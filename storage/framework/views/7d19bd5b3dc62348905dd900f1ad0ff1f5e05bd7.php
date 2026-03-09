<style>
    .form-group{ margin-bottom: 0.2rem !important;}
    ul{
        list-style: none !important;
        padding: 0px !important;
    }
    .ms-options-wrap > .ms-options > ul label{
        padding: 4px 4px;
    }
    .day_rate label{ font-style: italic; color: red; text-align: center}
</style>
<div class="modal" id="new">
    <div class="modal-dialog modal-xl">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Transport Rate</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">From City</label>
                            <select name="from_city" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                <?php echo App\Models\UmrahTransportCity::dropdown(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">To City</label>
                            <select name="to_city" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                <?php echo App\Models\UmrahTransportCity::dropdown(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Source</label>
                            <select name="source" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                <?php echo App\Models\Accounts\TransactionAccount::vendor_dd(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control form-control-sm" placeholder="Contact Number">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Currency</label>
                            <select name="currency_id" class="form-control form-control-sm">
                                <option value="">Select</option>
                                <?php echo App\Models\Currency::dropdown(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Curr Rate</label>
                            <input name="currency_rate" type="text" class="form-control form-control-sm" placeholder="Curr Rate">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Transport Type</label>
                            <select class="form-group form-control form-control-sm select2" name="transport_type">
                                <?php echo \App\Helpers\CommonHelper::vehicle_types(); ?>

                            </select>
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-12" style="border-right: 1px solid lightgrey;">
                            <h6 class="timeline-header bg-lightblue p-1"><a href="#">Transport Details</a></h6>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Purchase</label>
                                        <input type="text" name="purchase" class="form-control form-control-sm purchase_price coaster" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                    </div>
                                </div>
                                <!--col-->
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Sale Tax</label>
                                        <input type="text" name="sale_tax" class="form-control form-control-sm sale_tax" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                    </div>
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>VAT</label>
                                    <input type="text" name="vat" class="form-control form-control-sm vat" onkeyup="calculate_rate(this)" placeholder="Enter..">
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>With Holding</label>
                                    <input type="text" name="wh" class="form-control form-control-sm wh" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label style="font-size: 12px">Other Charges</label>
                                    <input type="text" name="oc" class="form-control form-control-sm oc" onkeyup="calculate_rate(this)" placeholder="Enter..">
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>Net Cost</label>
                                    <input type="text" name="net_purchase" class="form-control form-control-sm net_sale" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                </div>
                                <!--col-->

                                <div class="form-group col-md-3">
                                    <label>Select Agent</label>
                                    <select name="agent[]" class="form-control form-control-sm langOpt3" multiple id="langOpt3">
                                        <?php echo App\Models\Accounts\Agent::agent(); ?>

                                    </select>
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>Markup</label>
                                    <select class="form-control form-control-sm" name="markup_type">
                                        <option value="1">%</option>
                                        <option value="2">Fixed</option>
                                    </select>
                                </div>
                                <!--col-->
                                <div class="col-md-1">
                                    <label>Value</label>
                                    <input type="text" name="markup_value" class="form-control form-control-sm" placeholder="Enter...">
                                </div>
                                <div class="form-group col-md-1">
                                    <label>For Month</label>
                                    <select class="form-control form-control-sm" name="month">
                                        <?php for($i=1; $i<=12; $i++): ?>
                                            <option value="<?php echo e($i); ?>"><?php echo e(date("F", strtotime(date("Y") ."-". $i ."-01"))); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <!--row-->
                            <div class="row day_rate">
                                <?php for($i=1; $i<=31; $i++): ?>
                                    <div class="form-group col-md-1">
                                        <label><?php echo e($i); ?></label>
                                        <input type="text" name="validity_date_rate[<?php echo e($i); ?>]" class="form-control form-control-sm day_rate validity_date_rate<?php echo e($i); ?>" placeholder="Enter">
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <!--row-->
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info btn-xs" id="approve-first" style="display: none" onclick="approved_rate()">Approve First</button>
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/Rate_setup/transport_rate/modal.blade.php ENDPATH**/ ?>