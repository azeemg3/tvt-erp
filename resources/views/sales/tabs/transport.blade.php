<div class="tab-pane fade" id="transport" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <form id="transport-search-form">
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
            <div class="col-md-1">
                <div class="form-group">
                    <button type="button" class="btn btn-info btn-xs" onclick="get_transport_invoice(1, true)"><i class="fa fa-search"></i> </button>
                </div>
            </div>
        </div>
        <!--row-->
    </form>
    <button type="button" onclick="add_new_sale('transport-modal')" class="btn btn-primary btn-xs btn-flat float-right">Add New</button>
    <table class="table table-bordered">
        <thead>
        <tr class="table-active">
            <th>#</th>
            <th>#inv</th>
            <th>Inv Date</th>
            <th>Client Name</th>
            <th>Payable</th>
            <th>Receiveable</th>
            <th>Discount</th>
            <th>Profit</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="get_transport_invoice"></tbody>
    </table>
    <div class="card-footer clearfix">
        <div class="pagination-panel"></div>
    </div>
</div>
@include('sales.modals.transport-modal')