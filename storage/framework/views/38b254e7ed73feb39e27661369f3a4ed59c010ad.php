<div class="modal" id="new">
    <div class="modal-dialog modal-lg">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-warning">
                    <h5 class="modal-title">Payment to Agent Wallet</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Transaction Date</label>
                            <input name="trans_date" class="form-control form-control-sm date" placeholder="Transaction Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Posting Date</label>
                            <input name="posting_date" class="form-control form-control-sm date" placeholder="Posting Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Bank/Cash A/C</label>
                            <select name="payment_from" class="form-control form-control-sm select2">
                                <option value="payment_to">Select</option>
                                <?php echo App\Models\Accounts\TransactionAccount::bank_cash(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Payment Type</label>
                            <select name="payment_type" class="form-control form-control-sm select2 pt">
                                <option value="">Select</option>
                                <?php echo App\Helpers\Account::payment_type(); ?>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="exampleInputEmail1">Agent A/C</label>
                            <select name="agentID" class="form-control form-control-sm select2 client_inv">
                                <option value="">Select</option>
                                <?php echo App\Models\Accounts\Agent::agent(); ?>

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Narration</label>
                            <textarea name="narration" class="form-control form-control-sm narration" rows="10" placeholder="Narration" style="height: 40px !important;"></textarea>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control form-control-sm" placeholder="Paid Amount">
                        </div>
                    </div>
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

</div><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/agents/agent_wallet/modal.blade.php ENDPATH**/ ?>