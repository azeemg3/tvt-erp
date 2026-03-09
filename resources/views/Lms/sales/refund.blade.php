<div class="tab-pane fade" id="refund" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
    <button type="button" onclick="add_new_sale('refund-modal')" class="btn btn-primary btn-xs btn-flat float-right">Add New</button>
    <table class="table table-bordered">
        <thead>
        <tr class="table-active">
            <th>#</th>
            <th>#inv</th>
            <th>Pax Name</th>
            <th>Ref Date</th>
            <th>Ref Amount</th>
            <th>Charges</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="get_refunds"></tbody>
    </table>
    <div class="card-footer clearfix">
        <div class="pagination-panel"></div>
    </div>
</div>