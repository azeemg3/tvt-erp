<div class="modal" id="add-pax">
    <div class="modal-dialog modal-lg">
        <form id="tour-pax-form">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-danger">
                    <h5 class="modal-title">Passenger Detials</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Passport*</label>
                            <input name="passport[]" class="form-control form-control-sm" placeholder="Passport">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Pax Name</label>
                            <input name="pax_name[]" class="form-control form-control-sm" placeholder="Passenger Name">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Mobile</label>
                            <input name="mobile[]" class="form-control form-control-sm" placeholder="Mobile">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Pax Type</label>
                            <select name="pax_type[]" class="form-control form-control-sm">
                                {!! App\Helpers\CommonHelper::pax_type() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <button type="button" onclick="more_pax()" class="btn btn-xs btn-info btn-flat" style="margin-top: 25px"><i class="fa fa-plus"></i> </button>
                        </div>
                    </div>
                    <div class="more_pax"></div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_tour_pax('{{ route('lead_ticket.store') }}','ticket-form','ticket')">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>