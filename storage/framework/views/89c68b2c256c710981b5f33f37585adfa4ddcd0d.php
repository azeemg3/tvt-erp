<style>
    .form-group{
        margin-bottom: 0.5rem !important;
    }
</style>
<div class="modal" id="edit-modal">
    <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-0">
                <form id="form">
                    <input type="hidden" name="id" value="0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Update Booking Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td colspan="4" class="text-center"><h6 class="h6">Economy | 3 Days | JEDDAH</h6></td>
                        </tr>
                        <tr id="booking_details">
                            <td>BookingID: <span id="booking"></span></td>
                            <td align="center">Booking Date: <span id="booking_date"></span></td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Airline</label>
                                <select class="form-control form-control-sm select2" name="airline_id">
                                    <option value="">Select Airline</option>
                                    <?php echo App\Models\Airline::dropdown(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <label>PNR#</label>
                            <input type="text" name="pnr" class="form-control form-control-sm">
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <label>Flight#</label>
                            <input type="text" name="flight" class="form-control form-control-sm">
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Departure Date</label>
                                <input type="text" name="departure" autocomplete="off" class="form-control-sm form-control">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Departure Time</label>
                                <input type="time" name="departure_time" class="form-control-sm form-control">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Arrival Date</label>
                                <input type="text" name="arrival" autocomplete="off" class="form-control-sm form-control">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Arrival Time</label>
                                <input type="time" name="arrival_time" class="form-control-sm form-control">
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    <h6 class="h6 text-center">Traveller Information</h6>
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Iqama</th>
                            <th>Nationlaity</th>
                            <th>Passport#</th>
                            <th>Ticket No</th>
                        </tr>
                        <tbody id="traveller">
                        <tr>
                            <td>Muhammad Azeem Khalid</td>
                            <td>03244659501</td>
                            <td>87765</td>
                            <td>Pakistan</td>
                            <td>AH5146913</td>
                            <td>9741</td>
                            <td>123-876543256-9</td>
                        </tr>
                        <tr>
                            <td>Muhammad Azeem Khalid</td>
                            <td>03244659501</td>
                            <td>87765</td>
                            <td>Pakistan</td>
                            <td>AH5146913</td>
                            <td>9741</td>
                            <td>123-876543256-9</td>
                        </tr>
                        </tbody>
                    </table>
                    <h6 class="h6 text-center">Accommodation Details</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Hotel Type</label>
                            <select class="form-control form-control-sm select2">
                                <option value="">Hotel Type</option>
                                <?php echo App\Helpers\CommonHelper::hotel_star(); ?>

                            </select>
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <label>Hotel Name</label>
                           <input type="text" class="form-control form-control-sm" name="hotel_name">
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <label>Checkin Date</label>
                           <input type="text" class="form-control form-control-sm" name="checkin">
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <label>Checkin Time</label>
                           <input type="time" class="form-control form-control-sm" name="checkin_time">
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <label>Checkout Date</label>
                           <input type="text" class="form-control form-control-sm" name="checkout">
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <label>Checkout Time</label>
                           <input type="time" class="form-control form-control-sm" name="checkout_time">
                        </div>
                        <!--col-->
                        <div class="col-md-3">
                            <label>Transport Type</label>
                            <select class="form-control form-control-sm" name="transport_type">
                                <option value="0">Car</option>
                                <option value="1">Bus</option>
                            </select>
                        </div>
                        <!--col-md-3-->
                        <div class="col-md-3">
                            <label>City</label>
                            <select class="form-control form-control-sm select2" name="city">
                                <option value="0">Select City</option>
                                <?php echo App\Models\City::dropdown(); ?>

                            </select>
                        </div>
                        <!--col-md-3-->
                    </div>
                    <!--row--><br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-info card-outline">
                                <h3 class="card-title text-center">Passport Images</h3>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div id="passport_img"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-6">
                            <div class="card card-info card-outline">
                                <h3 class="card-title text-center">CNIC Images</h3>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div id="nic_images"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Update</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </form>
            </div>
    </div>

</div><?php /**PATH D:\xampp8.2\htdocs\uotrips\resources\views/agents/orders/edit-modal.blade.php ENDPATH**/ ?>