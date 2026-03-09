<div class="modal" id="excel-modal">
    <div class="modal-dialog">
        <form id="excel-form">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Ground Services</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Import File</label>
                                <input type="file" name="import_file" class="form-control form-control-sm">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-4" style="margin-top: 25px">
                            <div class="form-group">
                                <a href="{{ URL::asset('public/excel_sample/umrah-group-sample.xlsx') }}" download><i class="fa fa-download"></i> Download Sample File </a>
                            </div>
                        </div>
                    </div>
                    <div class="more-hotel-brn"></div>
                    <hr style="margin: 0px 0px 0px 0px !important;">
                    <div class="more-item"></div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-xs">Save</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>