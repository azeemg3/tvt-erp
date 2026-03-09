<div class="modal" id="room-type">
    <div class="modal-dialog">
        <form id="room-form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Room Type Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Room Type</label>
                            <input type="name" class="form-control form-control-sm" name="name" id="exampleInputEmail1" placeholder="Room Type">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">No Of Beds</label>
                            <input type="text" class="form-control form-control-sm" name="no_beds" id="exampleInputEmail1" placeholder="Room Type">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_room()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>