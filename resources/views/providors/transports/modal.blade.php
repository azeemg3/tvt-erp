<style>
    .form-group{ margin-bottom: 0.2rem !important;}
    ul{
        list-style: none !important;
        padding: 0px !important;
    }
    .ms-options-wrap > .ms-options > ul label{
        padding: 4px 4px;
    }
    .day_rate label{ font-style: italic; color: red; text-align: center}
</style>
<div class="modal" id="new">
    <div class="modal-dialog modal-xl">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Transport Rate</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">From City</label>
                            <select name="from_city" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\UmrahTransportCity::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">To City</label>
                            <select name="to_city" class="form-control form-control-sm select2">
                                <option value="">Select</option>
                                {!! App\Models\UmrahTransportCity::dropdown() !!}
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Transport Type</label>
                            <select class="form-group form-control form-control-sm select2" name="transport_type">
                                {!! \App\Helpers\CommonHelper::vehicle_types() !!}
                            </select>
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-12" style="border-right: 1px solid lightgrey;">
                            <h6 class="timeline-header bg-lightblue p-1"><a href="#">Transport Details</a></h6>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Purchase</label>
                                        <input type="text" name="purchase" class="form-control form-control-sm purchase_price coaster" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                    </div>
                                </div>
                                <!--col-->
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Sale Tax</label>
                                        <input type="text" name="sale_tax" class="form-control form-control-sm sale_tax" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                    </div>
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>VAT</label>
                                    <input type="text" name="vat" class="form-control form-control-sm vat" onkeyup="calculate_rate(this)" placeholder="Enter..">
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>With Holding</label>
                                    <input type="text" name="wh" class="form-control form-control-sm wh" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label style="font-size: 12px">Other Charges</label>
                                    <input type="text" name="oc" class="form-control form-control-sm oc" onkeyup="calculate_rate(this)" placeholder="Enter..">
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>Net Cost</label>
                                    <input type="text" name="net_purchase" class="form-control form-control-sm net_sale" onkeyup="calculate_rate(this)" onkeyup="calculate_rate(this)" placeholder="Enter..." >
                                </div>
                                <!--col-->
                                <div class="form-group col-md-1">
                                    <label>For Month</label>
                                    <select class="form-control form-control-sm" name="month">
                                        @for($i=1; $i<=12; $i++)
                                            <option value="{{ $i }}">{{ date("F", strtotime(date("Y") ."-". $i ."-01")) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <!--row-->
                            <div class="row day_rate">
                                @for($i=1; $i<=31; $i++)
                                    <div class="form-group col-md-1">
                                        <label>{{ $i }}</label>
                                        <input type="text" name="validity_date_rate[{{ $i }}]" class="form-control form-control-sm day_rate validity_date_rate{{ $i }}" placeholder="Enter">
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <!--row-->
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