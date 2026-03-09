<div class="modal" id="brn-modal">
    <div class="modal-dialog">
        <form id="form" class="form-horizontal">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-warning">
                    <h5 class="modal-title">Add BRN Price</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Hotel BRN Price</label>
                            <input type="text" name="hotel_brn_price" class="form-control form-control-sm" placeholder="Hotel BRN Price">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Transport BRN Price</label>
                            <input type="text" name="transport_brn_price" class="form-control form-control-sm" placeholder="Hotel BRN Price">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Flight Inv#</label>
                            <input type="text" name="flight_inv" class="form-control form-control-sm" placeholder="Flight Invoice No.">
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="approve_voucher()">Approved</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/agents/agent_booking/brn-modal.blade.php ENDPATH**/ ?>