<style>
    #voucher-modal .card-body{
        padding: 0.5rem !important;
    }
    #voucher-modal .card-header {
        padding: 0.5rem 0.5rem !important;
    }
</style>
<div class="modal" id="voucher-modal">
    <div class="modal-dialog modal-xl">
        <form id="group_voucher-form">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="GID" value="">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-orange">
                    <h5 class="modal-title">Voucher Amount</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form id="group_voucher-form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>#Voucher</label>
                                <input type="text" name="voucher" class="form-control form-control-sm" placeholder="Enter Voucher Number">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Currency</label>
                                <select name="currency" class="form-control form-control-sm">
                                    <option value="">Select Currency</option>
                                    <?php echo App\Models\Currency::dropdown(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Conversion Rate</label>
                                <input type="number" name="currency_rate" class="form-control form-control-sm" placeholder="0.00">
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header rounded-0">
                                    <h3 class="card-title">Hotel Reservation</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#BRN</th>
                                            <th>Hotel</th>
                                            <th>Service Date</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="get_hotel_data">
                                        <tr>
                                            <td><select name="brn[]" id="hotelBrn" class="form-control form-control-sm">
                                                    <option value="">Add Brn</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control form-control-sm hotel" name="hotel_id[]">
                                                    <option value="">Select Hotel</option>
                                                    <?php echo App\Models\Hotel::dropdown(); ?>

                                                </select>
                                            </td>
                                            <td><input type="text" name="service_date[]" class="form-control form-control-sm date" placeholder="srevice date"></td>
                                            <td><input type="text" name="price[]"  name="" class="form-control form-control-sm price" placeholder="Price"></td>
                                            <td><input type="text" name="qty[]" class="form-control form-control-sm qty" placeholder="Qty"></td>
                                            <td><input type="text" name="total_amount[]" class="form-control form-control-sm total" placeholder="Amount"></td>
                                            <td><button type="button" class="btn btn-info btn-sm" onclick="more_hotel_gv(this)"><i class="fa fa-plus"></i> </button></td>
                                        </tr>
                                        </tbody>
                                        <tbody id="more_hote_gv"></tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header rounded-0">
                                    <h3 class="card-title">Transport Reservation</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#BRN</th>
                                            <th>Transport</th>
                                            <th>Service Date</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="get_transport_data">
                                        <tr>
                                            <td>
                                                <select name="tbrn[]" id="trnsportBrn" class="form-control form-control-sm">
                                                    <option value="">Add New</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="transport_comp[]" class="form-control form-control-sm transport">
                                                    <option value="">Select Company</option>
                                                    <?php echo App\Models\Umrah\TransportCompany::dropdown(); ?>

                                                </select>
                                            </td>
                                            <td><input name="tservice_date[]" type="text" class="form-control form-control-sm date" placeholder="srevice date"></td>
                                            <td><input type="text" name="tprice[]" class="form-control form-control-sm price" placeholder="Price"></td>
                                            <td><input type="text" name="tqty[]" class="form-control form-control-sm qty" placeholder="Qty"></td>
                                            <td><input type="text" name="ttotal_amount[]" class="form-control form-control-sm total" placeholder="Amount"></td>
                                            <td><button type="button" class="btn btn-info btn-sm" onclick="more_transport_gv(this)"><i class="fa fa-plus"></i> </button></td>
                                        </tr>
                                        </tbody>
                                        <tbody id="more_transport_gv"></tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header rounded-0">
                                    <h3 class="card-title">Other Services</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="get_other_services">
                                        <tr>
                                            <td><select name="Oservice_name[]" id="otherServices" class="form-control form-control-sm">
                                                <option value="">Select Services</option>
                                                </select>
                                            </td>
                                            <td><input type="text" name="Oprice[]" class="form-control form-control-sm price" placeholder="Price"></td>
                                            <td><input type="text" name="Oqty[]" class="form-control form-control-sm qty" placeholder="Qty"></td>
                                            <td><input type="text" name="Ototal_amount[]" class="form-control form-control-sm total" placeholder="Amount"></td>
                                            <td><button type="button" class="btn btn-info btn-sm" onclick="more_os_gv(this)"><i class="fa fa-plus"></i> </button></td>
                                        </tr>
                                        </tbody>
                                        <tbody id="more_os_gv"></tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <div class="col-md-2 float-right">
                                <div class="form-group">
                                    <label><strong>Grand Total</strong></label>
                                    <input type="text" name="grand_total" readonly class="form-control form-control-sm total_amount" value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--row-->
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-xs" onclick="save_group_voucher()">Save</button>
                    <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>

</div><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/umrah/group_details/voucher_amount-modal.blade.php ENDPATH**/ ?>