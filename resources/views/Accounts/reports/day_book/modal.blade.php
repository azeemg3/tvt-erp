<div class="modal" id="new">
    <div class="modal-dialog modal-xl">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-warning">
                    <h5 class="modal-title">Voucher Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                        <tr class="text-info">
                            <th>#</th>
                            <th>Transaction A/C</th>
                            <th>Details</th>
                            <th>Dr</th>
                            <th>Cr</th>
                        </tr>
                        </thead>
                        <tbody id="vd"></tbody>
                    </table>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    {{--<div class="modal-footer">--}}
                        {{--<button type="submit" class="btn btn-success btn-xs">Submit</button>--}}
                        {{--<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>--}}
                    {{--</div>--}}
                </div>

            </div>
        </form>
    </div>

</div>