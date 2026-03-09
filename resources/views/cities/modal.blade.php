<div class="modal new-city" id="new">
    <div class="modal-dialog">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">City Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Country</label>
                            <select class="form-control form-control-sm select2" name="CID">
                                <option value="">Select</option>
                                {!! App\Models\Country::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Province</label>
                            <select class="form-control form-control-sm select2" name="PID">
                                <option value="">Select Province</option>
                                {!! App\Models\Province::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">City Name</label>
                            <input type="email" class="form-control form-control-sm" name="name" id="exampleInputEmail1" placeholder="City Name">
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