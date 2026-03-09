<div class="modal" id="new">
    <div class="modal-dialog modal-xl">
        <form id="wherehouse-form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Ziarat Rate</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">From City</label>
                            <select name="" class="form-control form-control-sm">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Ziarat City</label>
                            <select name="" class="form-control form-control-sm">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Contact Name</label>
                            <input type="text" name="" class="form-control form-control-sm" placeholder="Contact Name">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Contact Number</label>
                            <input type="text" name="" class="form-control form-control-sm" placeholder="Contact Number">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">From Date | Till Date</label>
                            <input type="text" name="" class="form-control form-control-sm" placeholder="YYYY-MM-DD | YYYY-MM-DD">
                        </div>
                    </div>
                    <hr style="margin: 0px 0px 0px 0px !important;">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency</label>
                            <select name="" class="form-control form-control-sm">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Curr Rate</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Curr Rate">
                        </div>
                        <div class="form-group col-md-1">
                            <label>Coaster</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <div class="form-group col-md-1">
                            <label>GMC</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <div class="form-group col-md-1">
                            <label>H1</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <div class="form-group col-md-1">
                            <label>Limousine</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <div class="form-group col-md-1">
                            <label>Private Car</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <div class="form-group col-md-1">
                            <label>Sedan Car</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <div class="form-group col-md-1">
                            <label>Sharing Bus</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <div class="form-group col-md-1">
                            <label>SUV Car</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <div class="form-group col-md-1" style="margin-top: 20px;">
                            <button type="button" class="btn btn-xs btn-dark" onclick="more_item()"><i class="fa fa-plus"></i> </button>
                        </div>
                    </div>
                    <div class="more-item"></div>
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