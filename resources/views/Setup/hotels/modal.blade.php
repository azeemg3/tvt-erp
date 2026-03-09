<div class="modal new-hotel" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            @CSRF
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0 border-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-yellow">
                    <h5 class="modal-title">Hotel Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Hotel Name</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Hotel Name">
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Country</label>
                            <select name="country" class="form-control form-control-sm select2 country">
                                {!! App\Models\Country::dropdown() !!}
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>City</label>
                            <select name="city" class="form-control form-control-sm select2 city">
                                {!! App\Models\City::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="col-md-6 form-group">
                            <label>Hotel Address</label>
                            <input type="text" name="hotel_address" class="form-control form-control-sm" placeholder="Enter">
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Hotel Images</label>
                                <input type="file">
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
        </form>
    </div>

</div>