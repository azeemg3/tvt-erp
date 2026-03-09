<div class="modal" id="new">
    <div class="modal-dialog">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0 border-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Currency Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                    <div class="form-group col-4">
                        <label>Country</label>
                        <select name="country" class="form-control form-control-sm select2">
                            {!! App\Models\Country::dropdown() !!}
                        </select>
                    </div>
                    <!--col-->
                    <div class="form-group col-4">
                        <label>Currency Symbol</label>
                        <select name="currency_symbol" class="form-control form-control-sm select2">
                            <option value="">Select Symbol</option>
                            @foreach($result as $key=>$val)
                                <option value="{{ $key }}">{{ $key }}</option>
                                @endforeach
                        </select>
                    </div>
                    <!--col-->
                    <div class="form-group col-4">
                        <label>Updated Conversion Rate</label>
                        <input type="text" name="rate" class="form-control form-control-sm conversion_rate" placeholder="0.00">
                    </div>
                    <!--col-->
                    </div>
                    <!--row-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>