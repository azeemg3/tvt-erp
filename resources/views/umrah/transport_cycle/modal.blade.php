<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Transport Cycle</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Route Type<span class="text-danger">*</span></label>
                                <select name="route_type" class="form-control form-control-sm">
                                    <option value="1">Regular Routes</option>
                                    <option value="2">Special Routes</option>
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        {{--<div class="col-md-9">--}}
                            {{--<div class="form-group">--}}
                                {{--<label>Route<span class="text-danger">*</span></label>--}}
                                {{--<select name="route[]" class="form-control form-control-sm select2 route" multiple>--}}
                                    {{--{!! App\Models\UmrahTransportCity::cycle() !!}--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<!--col-->--}}
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sector From</label>
                                <select name="from_city[]" class="form-control form-control-sm select2">
                                    <option value="">From City</option>
                                    {!! App\Models\UmrahTransportCity::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">To City</label>
                                <select name="to_city[]" class="form-control form-control-sm select2">
                                    <option value="">Select Sector</option>
                                    {!! App\Models\UmrahTransportCity::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label style="visibility: hidden" for="exampleInputEmail1">Sector</label>
                                <button type="button" onclick="more_transport_sector()" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <div class="more-tr-sectors"></div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Save</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>