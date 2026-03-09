<div class="modal" id="new">
    <div class="modal-dialog modal-xl">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Create Groups</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Agent</label>
                            <select name="agentID" onchange="add_new_agent(this)" class="form-control form-control-sm select2">
                                <option value="">Select Agent</option>
                                <option value="new">Add New</option>
                                <?php echo \App\Models\Accounts\Agent::agent(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Country</label>
                            <select name="country" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                <?php echo \App\Models\Country::dropdown(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Embassy</label>
                            <select name="embassy" class="form-control form-control-sm select2">
                                <option value="">Select Embassy</option>
                                <option value="Karachi">Karachi</option>
                                <option value="Islambad">Islambad</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Group Code</label>
                            <input type="text" name="group_code" class="form-control form-control-sm" placeholder="Group Code">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Group Name</label>
                            <input type="text" name="group_name" class="form-control form-control-sm" placeholder="Group Name">
                        </div>
                    </div>
                    <hr style="margin: 0px 0px 0px 0px !important;">
                    <div class="more-item"></div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Save</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>
<?php echo $__env->make('agents.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/umrah/group_details/modal.blade.php ENDPATH**/ ?>