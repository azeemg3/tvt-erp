<div class="modal" id="select-transport-seats">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded-0">
            <!-- Modal Header -->
            <div class="modal-header rounded-0 bg-gradient-maroon">
                <h5 class="modal-title">Check Available Seats</h5>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" class="brn" value="">
                <div class="row" id="transport-available-seat"></div><!--row-->
                <div class="alert alert-warning rounded-0 p-1">
                    <i class="icon fas fa-exclamation-triangle"></i> Note!<br>
                    Ground Handeling Staff will provide seat as per there arrangement
                    (Not Seat No. is Fix)
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" onclick="select_transport_seat()" class="btn btn-success btn-xs">Select</button>
                    <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                </div>
            </div><!--modal-body-->
        </div>
    </div>
</div><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/agents/agent_booking/select-transport-seats.blade.php ENDPATH**/ ?>