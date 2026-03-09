<style>
    .form-group{
        margin-bottom: 0.5rem !important;
    }
</style>
<div class="modal" id="new">
    <div class="modal-dialog">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Agent Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Agent Name*</label>
                            <input type="text" name="agent_name" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Mobile*</label>
                            <input type="text" name="agent_mobile" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Agent Email</label>
                            <input type="email" name="agent_email" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Country</label>
                            <select name="agent_country" class="form-control form-control-sm select2">
                                {!! App\Models\Country::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">City</label>
                            <select name="agent_city" class="form-control form-control-sm select2">
                                {!! App\Models\City::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" name="agent_address" class="form-control form-control-sm" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">OB Type</label>
                            <select name="OB_Type" class="form-control form-control-sm">
                                {!! App\Helpers\Account::dc() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">OB Amount</label>
                            <input type="email" name="OB" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter...">
                        </div>
                        <div class="form-group col-md-12">
                            <input type="text" name="agent_other_details" class="form-control form-control-sm" placeholder="Enter Other details..e.g. terms & conditions">
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