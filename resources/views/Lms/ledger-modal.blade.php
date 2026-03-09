<div class="modal" id="ledger-modal">
    <div class="modal-dialog modal-lg">
        <form id="ledger-form">
            <input type="hidden" name="leadId" value="{{ $result[0]->id }}">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Create Ledger</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Trans Account Name</label>
                            <input name="Trans_Acc_Name" class="form-control form-control-sm" placeholder="Trans Account Name">
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">OB Tyoe</label>
                            <select class="form-control form-control-sm" name="OB_Type">
                                {!! App\Helpers\Account::dc() !!}
                            </select>
                        </div>
                        <!--col-->
                        <div class="form-group col-md-2">
                            <label>Amount</label>
                            <input type="text" name="OB" class="form-control form-control-sm" placeholder="Amount">
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="creae_ledger()">Submit</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" onclick="close_form(6)">Close</button>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>