<style>
    .form-group{
        margin-bottom: 0.5rem !important;
    }
</style>
<div class="modal agent-modal" id="new">
    <div class="modal-dialog modal-lg">
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
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Agent Type</label>
                            <select name="agent_type" class="form-control form-control-sm" onchange="subagent(this.value)">
                                <option value="0">Sub Admin Agent</option>
                                <option value="1">Agent</option>
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Agent Code*</label>
                            <input type="text" name="agent_code" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Agent Name*</label>
                            <input type="text" name="agent_name" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Mobile*</label>
                            <input type="text" name="agent_mobile" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Agent Email</label>
                            <input type="email" name="agent_email" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="password" class="form-control form-control-sm" id="exampleInputEmail1" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Country</label>
                            <select name="agent_country" class="form-control form-control-sm select2">
                                {!! App\Models\Country::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Province</label>
                            <select name="agent_province" class="form-control form-control-sm select2">
                                {!! App\Models\Province::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">City</label>
                            <select name="agent_city" class="form-control form-control-sm select2">
                                {!! App\Models\City::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4 agentList" style="display:none">
                            <label for="exampleInputEmail1">Area</label>
                            <select name="ARID" class="form-control form-control-sm select2">
                                {!! App\Models\Area::dropdown() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Status</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="0">InActive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-4 agentList" style="display: none">
                            <label for="exampleInputEmail1">Assign Subagent to Agent</label>
                            <select name="agentID" class="form-control form-control-sm select2">
                                <option value="">Select Agent</option>
                                {!! App\Models\Accounts\Agent::subAgentList() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-8">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" name="agent_address" class="form-control form-control-sm" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-12">
                            <h6 style="text-decoration: underline">Assign Products to Agent:</h6>
                            <div class="form-check form-check-inline">
                                <input name="assign_products[]" type="checkbox" class="form-check-input" value="1">
                                <label class="form-check-label" for="exampleCheck1">Flight</label>
                            </div>
                            <!--form-check-->
                            <div class="form-check form-check-inline">
                                <input name="assign_products[]" type="checkbox" class="form-check-input" value="2">
                                <label class="form-check-label" for="exampleCheck1">Hotel</label>
                            </div>
                            <!--form-check-->
                            <div class="form-check form-check-inline">
                                <input name="assign_products[]" type="checkbox" class="form-check-input" value="3">
                                <label class="form-check-label" for="exampleCheck1">Visa</label>
                            </div>
                            <!--form-check-->
                            <div class="form-check form-check-inline">
                                <input name="assign_products[]" type="checkbox" class="form-check-input" value="4">
                                <label class="form-check-label" for="exampleCheck1">Transport</label>
                            </div>
                            <!--form-check-->
                            <div class="form-check form-check-inline">
                                <input name="assign_products[]" type="checkbox" class="form-check-input" value="5">
                                <label class="form-check-label" for="exampleCheck1">Umrah Packages</label>
                            </div>
                            <!--form-check-->
                            <div class="form-check form-check-inline">
                                <input name="assign_products[]" type="checkbox" class="form-check-input" value="7">
                                <label class="form-check-label" for="exampleCheck1">Tours</label>
                            </div>
                            <!--form-check-->
                            {{--<div class="form-check form-check-inline">--}}
                                {{--<input name="assign_products[]" type="checkbox" class="form-check-input" value="6">--}}
                                {{--<label class="form-check-label" for="exampleCheck1">Quarantine Packages</label>--}}
                            {{--</div>--}}
                            <!--form-check-->
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