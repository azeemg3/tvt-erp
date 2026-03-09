<div class="modal" id="new-sub_head">
    <div class="modal-dialog">
        <form id="zone-form">
            @CSRF
            <input type="hidden" name="id" value="0">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Zone Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="col-md-12 pad0">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Zone Name</label>
                                <input type="text" name="Z_Name" class="md-form-control form-control-sm">
                                <span class="md-line"></span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Country <sup class="text-danger">*</sup></label>
                                <select name="CTID" id="" class="js-example-basic-single form-control form-control-sm">
                                    <option value="">Select Country</option>
                                    {!! App\Models\Country::CT_List() !!}
                                </select>
                            </div>
                        </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" onclick="save_rec()" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>