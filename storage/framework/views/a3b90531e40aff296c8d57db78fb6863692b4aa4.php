<div class="modal" id="search-transport-option">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-0">
            <!-- Modal Header -->
            <div class="modal-header rounded-0 bg-gradient-warning">
                <h5 class="modal-title">Select Sectors</h5>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" class="tr-row">
                <div id="select-sectors"></div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-xs assign_sector">Submit</button>
                    <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                </div>
            </div><!--modal-body-->
        </div>
    </div>
</div>
<?php echo $__env->make('agents.agent_booking.select-transport-seats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/agents/agent_booking/search-transport-option-modal.blade.php ENDPATH**/ ?>