<div class="modal" id="mofa-modal">
    <div class="modal-dialog modal-xl">
        <form id="reservation-form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Mofa Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Group Name</label>
                                <input type="text" readonly name="group_name" class="form-control form-control-sm" placeholder="Group Name">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Group No</label>
                                <input type="text" readonly name="group_no" class="form-control form-control-sm" placeholder="Group No">
                            </div>
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="20%">MUTAMER NAME</th>
                                    <th>#MOFA</th>
                                    <th>#Visa</th>
                                    <th>Gender</th>
                                    <th>DOB</th>
                                    <th>Nationality</th>
                                    <th>Passport</th>
                                    <th>Mahram</th>
                                    <th>Relation</th>
                                    <th>Attach Visa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="get_mofa_data"></tbody>
                        </table>
                    </div>
                    <!--row-->
                </div>

            </div>
        </form>
    </div>

</div>