<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="wherehouse-form" class="form-horizontal">
            @CSRF
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0 border-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Add New Source</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">Code <sup class="text-danger">*</sup></label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">Name <sup class="text-danger">*</sup></label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">Web Link <sup class="text-danger">*</sup></label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text">
                                </div>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="clearfix"></div>
                        <div class="modal-footer py-0">
                            <button type="button" class="btn btn-sm btn-success" onclick="save_rec()">Submit</button>
                            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>