<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="wherehouse-form" class="form-horizontal">
            @CSRF
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0 border-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Add New Product</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                        <div class="form-row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Code</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control form-control-sm" id="inputEmail3" placeholder="Code">
                            </div>
                        </div>
                        </div>
                        <div class="col-6">
                        <div class="form-row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">HS Code</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control form-control-sm" id="inputEmail3" placeholder="HS Code">
                            </div>
                        </div>
                    </div>
                        <div class="col-6">
                        <div class="form-row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Category</label>
                            <div class="col-sm-8">
                                <select class="form-control form-control-sm">
                                    <option value="">Import</option>
                                    <option value="">Export</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-6">
                        <div class="form-row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Product Type</label>
                            <div class="col-sm-8">
                                <select class="form-control form-control-sm">
                                    <option value="">PAPER TUBE</option>
                                    <option value="">OTH FAN</option>
                                    <option value="">COTTON FABRICS</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="form-row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control form-control-sm" id="inputEmail3" placeholder="HS Code">
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