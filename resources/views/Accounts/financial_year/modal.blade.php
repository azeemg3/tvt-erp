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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Year</label>
                                <input type="text" name="start_year" value="" class="form-control form-control-sm date" placeholder="2022-07-01">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Year</label>
                                <input type="text" name="end_year" value="" class="form-control form-control-sm date" placeholder="2023-06-30">
                            </div>
                        </div>
                        <!--col-->
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