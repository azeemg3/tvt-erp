<div class="modal" id="ground-service-details-modal" style="overflow: scroll">
    <div class="modal-dialog modal-xl">
        <form id="ground-det-form">
            <input type="hidden" name="id" value="0">
            <input type="hidden" class="GID" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-olive">
                    <h5 class="modal-title">Add Ground Services</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="customRadio1" name="ground_services_type" checked="">
                                    <label for="customRadio1" class="custom-control-label">Direct Ground Services</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="ground_services_type">
                                <label for="customRadio2" class="custom-control-label">Indirect Ground Services</label>
                            </div>
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input type="text" name="service_contact_person" class="form-control form-control-sm" placeholder="Enter">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>External Agent</label>
                                <select type="text" onchange="add_external_agent(this)" name="external_agent" class="form-control form-control-sm">
                                    <option value="">Select External Agent</option>
                                    <option value="new">Add New</option>
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>License No.</label>
                                <input type="text" name="service_license_no" class="form-control form-control-sm" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Umrah Company</label>
                                <input type="text" name="umrah_company" class="form-control form-control-sm" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Company Name<span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control form-control-sm" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>License No.<span class="text-danger">*</span></label>
                                <input type="text" name="license_no" class="form-control form-control-sm" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Contact Perosn<span class="text-danger">*</span></label>
                                <input type="text" name="contact_person" class="form-control form-control-sm" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Contact No.<span class="text-danger">*</span></label>
                                <input type="text" name="contact_number" class="form-control form-control-sm" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email<span class="text-danger">*</span></label>
                                <input type="text" name="contact_email" class="form-control form-control-sm" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Web Address<span class="text-danger">*</span></label>
                                <input type="text" name="web_address" class="form-control form-control-sm" placeholder="e.g www.uotrips.com"></input>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Start Date<span class="text-danger">*</span></label>
                                <input type="text" name="start_date" class="form-control form-control-sm date" placeholder="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>End Date<span class="text-danger">*</span></label>
                                <input type="text" name="end_date" class="form-control form-control-sm date" placeholder="<?php echo e(date('Y-m-d')); ?>">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Purchsed By</label>
                                <select name="purchased_by" class="form-control form-control-sm select2">
                                    <option value="">--Select--</option>
                                    <?php echo App\Models\Accounts\TransactionAccount::vendor_dd(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea style="height: auto !important;" name="ground_services_address" class="form-control form-control-sm" placeholder="Ground Services Address"></textarea>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <h5>Representative:</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>City</label>
                                <select name="city_id[]" class="form-control form-control-sm select2">
                                    <option value="">Select City</option>
                                    <?php echo App\Models\City::dropdown(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Contact Person</label>
                                <input type="text" name="repersentative_person[]" class="form-control form-control-sm">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact No.</label>
                                <input type="text" name="repersentative_contact[]" class="form-control form-control-sm">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Add More</label>
                                <button type="button" onclick="more_repersentative()" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <div id="more_repersentative"></div>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Adult Rate</label>
                                <input type="number" name="adult_rate" onkeyup="total_amount(this)" class="form-control form-control-sm adult_rate" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Child Rate</label>
                                <input type="number" onkeyup="total_amount(this)" name="child_rate" class="form-control form-control-sm child_rate" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Infant Rate</label>
                                <input type="number" onkeyup="total_amount(this)" name="infant_rate" class="form-control form-control-sm infant_rate" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Adult Qty</label>
                                <input type="number" onkeyup="total_amount(this)" readonly name="adult_qty" class="form-control form-control-sm adult_qty" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Child Qty</label>
                                <input type="number" onkeyup="total_amount(this)" readonly name="child_qty" class="form-control form-control-sm child_qty" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Infant Qty</label>
                                <input type="number" onkeyup="total_amount(this)" readonly name="infant_qty" class="form-control form-control-sm infant_qty" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Total</label>
                                <input type="number" onkeyup="total_amount(this)" name="total" readonly class="form-control form-control-sm total" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <h5>Insurance:</h5>
                    <div class="row">
                        <input type="hidden" name="insured_person">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Adult Rate</label>
                                <input type="number" onkeyup="total_ins_amount()"  name="insurance_adult_rate" class="form-control form-control-sm insurance_adult_rate" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Child Rate</label>
                                <input type="number"  name="insurance_child_rate" class="form-control form-control-sm insurance_child_rate" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Infant Rate</label>
                                <input type="number"  name="insurance_infant_rate" class="form-control form-control-sm insurance_infant_rate" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Adult Qty</label>
                                <input type="number" name="insured_adult" readonly class="form-control form-control-sm insured_adult" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Child Qty</label>
                                <input type="number" name="insured_child" readonly class="form-control form-control-sm insured_child" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Infant Qty</label>
                                <input type="number" name="insured_infant" readonly class="form-control form-control-sm insured_infant" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Total</label>
                                <input type="number" name="total_insurance" readonly class="form-control form-control-sm total_insurance" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Insured Pax</label>
                                <input type="text" name="" readonly class="form-control form-control-sm insurance_linked_pax">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label style="visibility: hidden">Infantfafsaf</label>
                                <button type="button" onclick="open_visitor_list(0)" class="btn btn-xs btn-outline-warning"><i class="fa fa-user"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <h5>Additional Services:</h5>
                    <div class="row add_service_cal">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Service Name</label>
                                <select name="service_name[]" class="form-control form-control-sm service">
                                    <option value="">Select</option>
                                    <?php echo App\Helpers\CommonHelper::additional_services(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Adult Rate</label>
                                <input type="number" name="aadult_rate[]" class="form-control form-control-sm aadult_rate" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Child Rate</label>
                                <input type="number" name="achild_rate[]" class="form-control form-control-sm achild_rate" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Infant Rate</label>
                                <input type="number" name="ainfant_rate[]" class="form-control form-control-sm ainfant_rate" placeholder="0.00">
                                <input type="hidden" name="got_services_by[]" class="form-control form-control-sm got_services_by">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Adult Qty</label>
                                <input type="number" name="aadult_qty[]" readonly class="aadult_qty form-control form-control-sm aadult_qty" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Child Qty</label>
                                <input type="number" name="achild_qty[]" readonly class="achild_qty form-control form-control-sm achild_qty" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Infant Qty</label>
                                <input type="number" name="ainfant_qty[]" readonly class="ainfant_qty form-control form-control-sm ainfant_qty" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Total</label>
                                <input type="number" name="total_service_amount[]" readonly class="form-control form-control-sm total_service_amount" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <label>Pax Linked</label>
                            <input type="text" readonly class="form-control form-control-sm service_linked_pax">
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label style="visibility: hidden">Infantfafsaf</label>
                                <button type="button" onclick="more_services()" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> </button>
                                <button type="button" onclick="open_visitor_list(1, this)" class="btn btn-xs btn-outline-warning"><i class="fa fa-user"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <div class="more-services"></div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Currency</label>
                                <select class="form-control form-control-sm">
                                    <option value="">Select Currency</option>
                                    <?php echo App\Models\Currency::dropdown(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Conversion Rate</label>
                                <input type="text" class="form-control form-control-sm" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-12 float-right">
                            <div class="form-group float-right">
                                <label>Grand Total</label>
                                <input type="text" name="grand_total" class="form-control form-control-sm grand_total">
                            </div>
                        </div>
                    </div>
                    <!--row-->
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_new_gs_det()">Save</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>
<?php echo $__env->make('umrah.ground_services.select-mutamer-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('umrah.ground_services.external-agent-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/umrah/ground_services/modal.blade.php ENDPATH**/ ?>