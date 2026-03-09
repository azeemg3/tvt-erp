<div class="modal" id="new">
    <div class="modal-dialog">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Designation Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Designation</label>
                        <input type="email" class="form-control form-control-sm" id="exampleInputEmail1" name="name" placeholder="Designation">
                    </div>
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

</div>