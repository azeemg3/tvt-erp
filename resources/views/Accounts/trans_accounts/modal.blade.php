<div class="modal" id="new">
    <div class="modal-dialog">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Accounts Detail</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Account Type</label>
                            <select name="PID" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Accounts\SubHeadAccount::dropdown() !!}
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="code" value="{{ $code }}" class="form-control form-control-sm" placeholder="e,g 012">
                            </div>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Transaction Account</label>
                            <input type="email" name="Trans_Acc_Name" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Transaction Account">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">OB Type</label>
                            <select name="OB_Type" class="form-control form-control-sm">
                                {!! App\Helpers\Account::dc() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">OB Amount</label>
                            <input type="email" name="OB" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Opening Balacne">
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