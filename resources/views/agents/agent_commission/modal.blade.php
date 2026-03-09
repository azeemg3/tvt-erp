<style>
    .form-group{ margin-bottom: 0.2rem !important;}
    ul{
        list-style: none !important;
        padding: 0px !important;
    }
    .ms-options-wrap > .ms-options > ul label{
        padding: 4px 4px;
    }
</style>
<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-warning">
                    <h5 class="modal-title">Agents Commission</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Products</label>
                            <select name="product" class="form-control form-control-sm select2">
                                <option value="">Select Product</option>
                               {!! App\Helpers\CommonHelper::services() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Validity</label>
                            <input type="text" name="validity" class="form-control form-control-sm" id="reservation" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Currency</label>
                            <select name="currency" class="form-control form-control-sm">
                                {!! App\Models\Currency::dropdown() !!}
                            </select>
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label>Select Subadmin</label>
                                    <select name="agents[]" class="form-control form-control-sm langOpt3" multiple id="langOpt3">
                                        {!! App\Models\Accounts\Agent::subAgentList() !!}
                                    </select>
                                </div>
                                <!--col-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Total Commission</label>
                                        <input type="number" name="total_commission" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>Sub Admin Comm</label>
                                    <input type="number" name="subadmin_commission" class="form-control form-control-sm" placeholder="Enter...">
                                </div>
                            </div>
                            <!--row-->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Agent Commission</label>
                                        <input type="number" name="agent_commission" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>GO Commission</label>
                                        <input type="number" name="go_commission" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <!--row-->
                        </div>
                    </div>
                    <!--row-->
                {{--<div class="more-items"></div>--}}
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