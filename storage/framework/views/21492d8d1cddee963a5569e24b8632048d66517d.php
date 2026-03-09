<style>
    .form-group{ margin-bottom: 0.2rem !important;}
    ul{
        list-style: none !important;
        padding: 0px !important;
    }
    .ms-options-wrap > .ms-options > ul label{
        padding: 4px 4px;
    }
</style>
<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-warning">
                    <h5 class="modal-title">Packages Assign to Agents</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Package Type</label>
                            <select name="pkg_type" class="form-control form-control-sm select2"
                                    onchange="fetch_tour_pkg(this.value)">
                                <option value="">Package Type</option>
                                <?php echo App\Helpers\cms::tour_types(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Select Package</label>
                            <select name="pkg_id" class="form-control form-control-sm select2" id="selected_packages">
                                <option value="">Select Package</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Validity</label>
                            <input type="text" name="validity" class="form-control form-control-sm" id="reservation" autocomplete="off">
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label>Select Agent</label>
                                    <select name="agents[]" class="form-control form-control-sm langOpt3" multiple id="langOpt3">
                                        <?php echo App\Models\Accounts\Agent::subAgentList(); ?>

                                    </select>
                                </div>
                                <!--col-->
                                <div class="form-group col-md-2">
                                    <label>Discount Type</label>
                                    <select class="form-control form-control-sm" name="discount_type">
                                        <option value="1">%</option>
                                        <option value="2">Fixed</option>
                                    </select>
                                </div>
                                <!--col-->
                                <div class="col-md-2">
                                    <label>Value</label>
                                    <input type="text" name="discount" class="form-control form-control-sm" placeholder="Enter...">
                                </div>
                            </div>
                            <!--row-->
                        </div>
                    </div>
                    <!--row-->
                
                <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/agents/custom-discount-modal.blade.php ENDPATH**/ ?>