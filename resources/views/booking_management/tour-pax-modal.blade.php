<div class="modal" id="tour-pax-modal">
    <div class="modal-dialog modal-xl">
        <form id="pax-form" enctype="multipart/form-data">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="TID" id="TID">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Pax Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2 form-group">
                            <label>Title</label>
                            <select class="form-control form-control-sm" name="title">
                                <option value="">Title</option>
                                {!! App\Helpers\CommonHelper::pax_title() !!}
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Pax Name</label>
                            <input type="text" placeholder="Pax Name" class="form-control form-control-sm" name="pax_name">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Father/Husband Name</label>
                            <input type="text" placeholder="Father/Husband Name " class="form-control form-control-sm" name="father_name">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Middle Name</label>
                            <input type="text" placeholder="Middle Name" class="form-control form-control-sm" name="middle_name">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Last Name</label>
                            <input type="text" placeholder="Last Name" class="form-control form-control-sm" name="last_name">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Gender</label>
                            <select class="form-control form-control-sm" name="gender">
                                <option value="">Gender</option>
                                {!! App\Helpers\CommonHelper::gender() !!}
                            </select>
                        </div>
                        <div class="col-md-1 form-group">
                            <label>Pax Type</label>
                            <select class="form-control form-control-sm" name="pax_type" onchange="visa_rate(this)">
                                <option value="">Pax Type</option>
                                <option value="1">Adult</option>
                                <option value="2">Child</option>
                                <option value="3">Infant</option>
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <label>CNIC</label>
                            <input type="text" class="form-control form-control-sm" placeholder="CNIC" name="cnic">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Nationality</label>
                            <select class="form-control form-control-sm select2" name="nationality">
                                <option value="">Nationality</option>
                                {!! App\Models\Country::dropdown() !!}
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <label>DOB</label>
                            <input type="text" class="form-control form-control-sm dob" placeholder="d-m-yyyy" name="dob">
                        </div>
                        <div class="col-md-1 form-group">
                            <label>Age</label>
                            <input type="text" class="form-control form-control-sm" id="age" placeholder="Age" name="age">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control form-control-sm" name="address" placeholder="Address">
                        </div>
                        <h5 class="col-md-12"> <i class="fas fa-passport" aria-hidden="true"></i> Passprt Details: </h5>
                        <div class="col-md-2 form-group">
                            <select class="form-control form-control-sm" name="passport_type">
                                <option value="">Passport Type</option>
                                {!! App\Helpers\CommonHelper::passport_type() !!}
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" class="form-control form-control-sm" placeholder="Passport#" name="passport">
                        </div>
                        <div class="col-md-2 form-group">
                            <select class="form-control form-control-sm select2" name="passport_country">
                                <option value="">Passport Country</option>
                                {!! App\Models\Country::dropdown() !!}
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" class="form-control form-control-sm date" placeholder="Issue Date" name="issue_date">
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" class="form-control form-control-sm date" placeholder="Expiry Date" name="expirty_date">
                        </div>
                    </div><!--row-->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputFile">Upload CNIC</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" multiple name="cnic_photos[]">
                                        <label class="custom-file-label" for="exampleInputFile">CNIC(front, back)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputFile">Upload Passport</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" multiple name="passport_photos[]">
                                        <label class="custom-file-label" for="exampleInputFile">Passport(First Page)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputFile">Vaccine Card</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="vaccine_card_photo">
                                        <label class="custom-file-label" for="exampleInputFile">Vaccine Card</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-xs">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                    <div class="col-md-12 table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Pax Type</th>
                                <th>Nationality</th>
                                <th>passport</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="get_pax_data"></tbody>
                        </table>
                    </div>
                </div><!--modal-body-->
            </div>
        </form>
    </div>
</div>