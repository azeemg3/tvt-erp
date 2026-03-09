<div class="modal" id="ground-services-modal">
    <div class="modal-dialog">
        <form id="gs-form">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="GID" value="0">
            <input type="hidden" class="adult" value="0">
            <input type="hidden" class="child" value="0">
            <input type="hidden" class="infant" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Ground Services</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Services</label>
                                <select name="service_id[]" class="form-control form-control-sm select2" id="fetch_gs" onchange="add_new_gs_det(this.value)">
                                    <option value="">--Select Service--</option>
                                    <option value="new">Add New</option>
                                    <?php echo App\Models\Umrah\GroundService::dropdown(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">#of Pax</label>
                                <input type="text" name="no_pax[]" class="form-control form-control-sm" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        
                            
                                
                                
                            
                        
                        
                    </div>
                    <hr style="margin: 0px 0px 0px 0px !important;">
                    <div class="more-item"></div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_gs()">Save</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/umrah/group_details/ground_services-modal.blade.php ENDPATH**/ ?>