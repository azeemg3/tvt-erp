<div class="modal" id="document-modal">
    <div class="modal-dialog modal-xl">
        <form id="file-upload" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="leadId" value="{{ $result[0]->id }}">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Document Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Document Type</label>
                            <select name="doc_type" class="form-control form-control-sm">
                                <option value="">Select Type</option>
                                {!! App\Helpers\CommonHelper::doc_type() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">E-Number*</label>
                            <input name="e_number" class="form-control form-control-sm" placeholder="Enter...">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Pax Name</label>
                            <input type="text" name="pax_name" class="form-control form-control-sm" placeholder="Enter....">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Attach File*</label>
                            <div class="input-group input-group-sm">
                                <div class="custom-file">
                                    <input type="file" name="doc_url" class="custom-file-input">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-xs">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="close_form(9)">Close</button>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>