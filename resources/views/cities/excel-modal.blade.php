<div class="modal" id="excel">
    <div class="modal-dialog">
        <form id="form-excel">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Import City in Excel
                        <a href="{{ URL::asset('public/excel_sample/cities-sample.xlsx') }}" download class="btn btn-xs" download>Download Sample <i class="fa fa-file-download"></i> </a></h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Country</label>
                            <select class="form-control form-control-sm select2" name="ARID">
                                <option value="">Select</option>
                                {!! App\Models\Country::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Import Excel</label>
                            <input type="file" name="import_file">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-xs">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>