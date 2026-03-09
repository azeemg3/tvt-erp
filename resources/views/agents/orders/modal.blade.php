<style>
    .form-group{
        margin-bottom: 0.5rem !important;
    }
</style>
<div class="modal" id="view">
    <div class="modal-dialog modal-lg">
        <form id="form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-warning">
                    <h5 class="modal-title">Booking Details</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td colspan="4" class="text-center"><h6 class="h6">Economy | 3 Days | JEDDAH</h6></td>
                        </tr>
                        <tr>
                            <td>Payment Status: <span class="payment_status"></span></td>
                            <td colspan="3" class="text-center">Booking Status: <span class="booking_status"></span></td>
                        </tr>
                        <tr id="booking_details">
                            <td>BookingID: 01</td>
                            <td>Booking Date: 2022-01-07</td>
                            <td>Departure:2022-01-07 02:06</td>
                            <td>Arrival:2022-01-07 12:07</td>
                        </tr>
                    </table>
                    <h6 class="h6 text-center">Traveller Information</h6>
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Iqama</th>
                            <th>Nationlaity</th>
                            <th>Passport#</th>
                            <th>Flight#</th>
                            <th>Ticket No</th>
                        </tr>
                        <tbody>
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
                    <table class="table table-striped">
                        <tr>
                            <th>City</th>
                            <th>Hotel Type</th>
                            <th>Hotel Name</th>
                            <th>Checkin</th>
                            <th>Checkout</th>
                            <th>Nights</th>
                        </tr>
                        <tr>
                            <td>Jeddah</td>
                            <td>Economy</td>
                            <td>Test Hotel</td>
                            <td>2022-01-04 13:42:00</td>
                            <td>2022-01-04 13:42:00</td>
                            <td>04</td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-info card-outline">
                                    <h3 class="card-title text-center">Passport Images</h3>
                                <!-- /.card-header -->
                                <div class="card-body">

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

                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Approve</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>