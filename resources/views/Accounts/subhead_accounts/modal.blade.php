<div class="modal" id="new">
    <div class="modal-dialog">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Subhead Account</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Root Account</label>
                            <select name="" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Accounts\RootAccount::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Head Account</label>
                            <select name="HID" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Accounts\HeadAccount::dropdown() !!}
                            </select>
                        </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-12">
                        <label for="exampleInputEmail1">Subhead Account</label>
                        <input type="text" name="name" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Subhead Account">
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