<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Employee Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Gender*</label>
                            <select name="gender" class="form-control form-control-sm">
                                {!! App\Helpers\CommonHelper::gender() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">First Name<span class="text-danger">*</span></label>
                            <input name="first_name" class="form-control form-control-sm" placeholder="First Name">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Last Name<span class="text-danger">*</span></label>
                            <input name="last_name" class="form-control form-control-sm" placeholder="Last Name">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Designation</label>
                            <select class="form-control form-control-sm select2" name="DID">
                                {!! App\Models\Designation::dropdown() !!}
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Date of Birth</label>
                            <input name="dob" class="form-control form-control-sm date" autocomplete="off" placeholder="Date Of Birth">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">CNIC</label>
                            <input name="cnic" class="form-control form-control-sm" placeholder="CNIC">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Martial Status</label>
                            <select name="martial_status" class="form-control form-control-sm">
                                <option value="">Select</option>
                                {!! App\Helpers\CommonHelper::martial_status() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Employment Status</label>
                            <select name="emp_status" class="form-control form-control-sm">
                                <option value="">Select</option>
                                {!! App\Helpers\CommonHelper::emp_status() !!}
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Home Phone</label>
                            <input name="home_phone" type="text" class="form-control form-control-sm" placeholder="Home Phone">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Mobile Phone<span class="text-danger">*</span></label>
                            <input name="mobile_phone" type="text" class="form-control form-control-sm" placeholder="Mobile Phone">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Work Email<span class="text-danger">*</span></label>
                            <input type="text" name="work_email" class="form-control form-control-sm" placeholder="Work Email">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Private Email</label>
                            <input type="text" name="private_email" class="form-control form-control-sm" placeholder="Private Email">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Country</label>
                            <select name="CID" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\Country::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>City</label>
                            <select name="CTID" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\City::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control form-control-sm" placeholder="Address">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Department</label>
                            <select class="form-control form-control-sm select2" name="DPID">
                                {!! App\Models\Department::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Joining Date</label>
                            <input type="text" autocomplete="off" name="joining_date" class="form-control form-control-sm date" placeholder="Joining Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Confirmation Date</label>
                            <input type="text" name="confirmation_date" autocomplete="off" class="form-control form-control-sm date" placeholder="Confirmation Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Terminate Date</label>
                            <input type="text" name="terminate_date" autocomplete="off" class="form-control form-control-sm date" placeholder="Terminate Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Basic Salary</label>
                            <input type="number" name="basic_salary" class="form-control form-control-sm" placeholder="Basic Salary">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Allownces</label>
                            <input type="number" name="allownces" class="form-control form-control-sm" placeholder="Allownces">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Net Salary</label>
                            <input type="number" name="net_salary" class="form-control form-control-sm" placeholder="Net Salary">
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Create User as Well</label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Password*</label>
                            <input type="password" name="password" class="form-control form-control-sm" placeholder="Password">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Confirm Password*</label>
                            <input type="password" class="form-control form-control-sm" placeholder="Confirm Password">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Select Role*</label>
                            <select class="form-control form-control-sm select2" name="roles">
                                @foreach($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
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