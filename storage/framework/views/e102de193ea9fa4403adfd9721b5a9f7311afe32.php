<style>
    .form-group{
        margin-bottom: 0.3rem !important;
    }
</style>
<div class="modal" id="new">
    <div class="modal-dialog modal-xl">
        <form id="form">
            <input type="hidden" name="UID" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Add Rate</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Purchased By</label>
                            <select class="form-control form-control-sm source" disabled>
                                <?php echo App\Models\Accounts\TransactionAccount::vendor_dd(); ?>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Vehicle Type</label>
                            <select class="form-control form-control-sm transport_type">
                                <?php echo App\Helpers\CommonHelper::room_type(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Total Pax</label>
                            <input type="text" name="total_pax" class="form-control form-control-sm" readonly placeholder="Total Pax">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Total Vehicle</label>
                            <input type="text" name="total_vehicle" class="form-control form-control-sm" readonly placeholder="Total Vehicle">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Rate</label>
                            <input onkeyup="total_cal(this)" type="text" name="rate" class="form-control form-control-sm" placeholder="Rate">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Total</label>
                            <input type="text" name="total" class="form-control form-control-sm" placeholder="Total" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Confirmaton No.</label>
                            <input type="text" name="confirmation_no" class="form-control form-control-sm" placeholder="Confirmation No.">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Remarks</label>
                            <input type="text" name="remarks" class="form-control form-control-sm" placeholder="Remarks">
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

</div><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/booking_confirmation/transport_confirmation/modal.blade.php ENDPATH**/ ?>