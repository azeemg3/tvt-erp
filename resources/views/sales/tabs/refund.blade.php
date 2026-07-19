<div class="tab-pane fade" id="refund" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <form id="refund-search-form">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <input type="text" name="df" class="form-control form-control-sm date" placeholder="Date From">
            </div>
        </div>
        <!--col-->
        <div class="col-md-2">
            <div class="form-group">
                <input type="text" name="dt" class="form-control form-control-sm date" placeholder="Date To">
            </div>
        </div>
        <!--col-->
        <div class="col-md-2">
            <div class="form-group">
                <select name="ledger" class="form-control form-control-sm select2 fetch_customers">
                </select>
            </div>
        </div>
        <!--col-->
        <div class="col-md-2">
            <div class="form-group">
                <input type="text" name="inv_no" class="form-control form-control-sm" placeholder="Invoice No" inputmode="numeric">
            </div>
        </div>
        <!--col-->
        <div class="col-md-1">
            <div class="form-group">
                <button type="button" class="btn btn-info btn-xs" onclick="get_ticket_refunds(1, true)"><i class="fa fa-search"></i> </button>
            </div>
        </div>
    </div>
        <!--row-->
    </form>
    <button type="button" onclick="add_new_sale('ticket-refund-modal')" class="btn btn-primary btn-xs btn-flat float-right mb-2">Add New</button>
    <div class="table-responsive">
    <table id="refund-sale-table" class="table table-bordered table-striped sale-data-table w-100">
        <thead>
        <tr class="table-active">
            <th>#</th>
            <th>#inv</th>
            <th>Pax Name</th>
            <th>Client</th>
            <th>Ticket No</th>
            <th>Ref Date</th>
            <th>Ref Amount</th>
            <th>Vendor Charges</th>
            <th>Service Charges</th>
            <th>Net Refund</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="get_ticket_refunds"></tbody>
    </table>
    </div>
</div>
@include('sales.modals.refund-modal')
