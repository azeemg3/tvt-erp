<div class="modal" id="new">
    <div class="modal-dialog">
        <form id="wherehouse-form">
            @CSRF
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0 border-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Add New Product Type</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-row">
                                <label for="inputdefault" class="col-3 col-form-label">Product Type <sup class="text-danger">*</sup></label>
                                <div class="col-9">
                                    <input class="form-control form-control-sm" id="" name="WH_Name" type="text">
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="clearfix"></div>
                        <div class="modal-footer py-0">
                            <button type="button" class="btn btn-sm btn-flat btn-success" onclick="save_rec()">Submit</button>
                            <button type="button" class="btn btn-sm btn-flat btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>