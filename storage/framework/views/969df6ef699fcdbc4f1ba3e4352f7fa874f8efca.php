<div class="modal" id="transport_brn-modal">
    <div class="modal-dialog">
        <form id="transportBrn-form">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="GID" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Transport BRN</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="exampleInputEmail1">BRN#</label>
                                <select name="TRBRN[]" class="form-control form-control-sm select2" id="fetch_transport_brn" onchange="transport_reservation(this.value), available_capacity(this)">
                                    <option value="">--Select--</option>
                                    <option value="new">Add New</option>
                                    <?php echo App\Models\Umrah\TransportReservationBrn::dropdown(); ?>


                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Available</label>
                                <input readonly="" type="text" name="" class="form-control form-control-sm available" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">#of Pax</label>
                                <input type="text" name="no_pax[]" class="form-control form-control-sm no_pax" onchange="enter_pax(this)" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label style="visibility: hidden">Add</label>
                                <button type="button" onclick="more_trans_brn()" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <div class="more-transport-brn"></div>
                    <hr style="margin: 0px 0px 0px 0px !important;">
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_transport_brn()">Save</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/umrah/group_details/transport_brn-modal.blade.php ENDPATH**/ ?>