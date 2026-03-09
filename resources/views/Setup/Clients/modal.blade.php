<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="wherehouse-form" class="form-horizontal">
            @CSRF
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0 border-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Add New Client</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">First Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text" placeholder="First Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">Last Name </label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">Phone</label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text" placeholder="Phone">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">City</label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text" placeholder="City">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">Zip</label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text" placeholder="Zip Code">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">T-24 Code</label>
                                <div class="col-sm-8">
                                    <input class="form-control form-control-sm" id="" name="" type="text" placeholder="T-24 Code">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-4 col-form-label">Branch</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-sm select2">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-2 col-form-label">Address 1</label>
                                <div class="col-sm-10">
                                    <input class="form-control form-control-sm" id="" name="" type="text" placeholder="Address 1">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-row">
                                <label for="inputdefault" class="col-sm-2 col-form-label">Address 2</label>
                                <div class="col-sm-10">
                                    <input class="form-control form-control-sm" id="" name="" type="text" placeholder="Address 2">
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