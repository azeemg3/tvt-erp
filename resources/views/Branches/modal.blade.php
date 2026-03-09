<div class="modal" id="new">
    <div class="modal-dialog">
        <form id="wherehouse-form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Branch Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Branch Name</label>
                                <input type="text" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Branch Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Branch Manager Name</label>
                                <input type="text" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Branch Manager Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Branch Manager Mobile</label>
                                <input type="text" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Branch Manager Mobile">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Branch Manager Email</label>
                                <input type="text" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Branch Manager Email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Branch Phone</label>
                                <input type="text" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Branch Phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Country</label>
                                <select class="form-control form-control-sm">
                                    <option value="">Select Country</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Country</label>
                                <select class="form-control form-control-sm">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Branch Address">
                            </div>
                        </div>
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