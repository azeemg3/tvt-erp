<div class="modal new-hotel" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            @CSRF
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0 border-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-yellow py-2">
                    <h5 class="modal-title">Hotel Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                </div>
                <div class="modal-footer justify-content-between py-2">
                    <small class="text-muted">Please complete required fields before submitting.</small>
                    <div>
                        <button type="button" class="btn btn-sm btn-light border" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-sm btn-success" onclick="save_rec()">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>