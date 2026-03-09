<div class="modal" id="receipt-modal">
    <div class="modal-dialog modal-xl">
        <form id="receipt-form">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="leadId" value="<?php echo e($result[0]->id); ?>">
            <input type="hidden" name="account_code" value="<?php echo e($result[0]->ledger); ?>">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Receipt Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Transaction Date*</label>
                            <input type="text" name="transaction_date" class="form-control form-control-sm date" placeholder="Transaction Date">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm">
                                <?php echo App\Helpers\Account::payment_type(); ?>

                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-1">
                            <label for="exampleInputEmail1">Inv No.</label>
                            <input type="text" name="SID" class="form-control form-control-sm" placeholder="Invoice No">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Amount</label>
                            <input type="text" name="amount" class="form-control form-control-sm" placeholder="amount">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency</label>
                            <select name="currency" class="form-control form-control-sm currency_type">
                                <?php echo App\Models\Currency::dropdown(); ?>

                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Currency Rate</label>
                            <input type="text" name="currency_rate" class="form-control form-control-sm currency_rate" placeholder="Currency Rate">
                        </div>
                        <!--col-->
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1">Particulars</label>
                            <textarea name="particulars" class="form-control form-control-sm" style="height: 70px !important;" placeholder="Particulars"></textarea>
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_receipt()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="get_receipts(1)">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/Lms/sales/modals/receipt-modal.blade.php ENDPATH**/ ?>