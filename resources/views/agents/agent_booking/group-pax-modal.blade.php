<div class="modal" id="visitor-list-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-0">
            <!-- Modal Header -->
            <div class="modal-header rounded-0 bg-gradient-warning">
                <h5 class="modal-title">Visitor List</h5>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="assign-visitor-form">
                    <input type="hidden" name="agentID" id="selected_agent_id">
                    <input type="hidden" id="visitor_list_visa_price" name="visa_price">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Pax Type</th>
                                <th>Nationality</th>
                                <th>passport</th>
                            </tr>
                            </thead>
                            <tbody id="get_group_pax_data"></tbody>
                        </table>
                    </div>
                </div>
                </form>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" onclick="assign_visitor()" class="btn btn-success btn-xs">Submit</button>
                    <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                </div>
            </div><!--modal-body-->
        </div>
    </div>
</div>