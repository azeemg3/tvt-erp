<div class="modal" id="hotel-reservation">
    <div class="modal-dialog modal-xl">
        <form id="hotel-reservation-form">
            <input type="hidden" name="id" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-dark">
                    <h5 class="modal-title">Hotel BRN</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>#BRN<span class="text-danger">*</span></label>
                                <input type="text" name="brn" class="form-control form-control-sm" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Booking Date<span class="text-danger">*</span></label>
                                <input type="text" name="booking_date" class="form-control form-control-sm date" placeholder="Enter...">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">City</label>
                                <select name="city_id" onchange="add_new_city(this)" class="form-control form-control-sm select2">
                                    <option value="">Select City</option>
                                    <option value="new">Add New</option>
                                    <?php echo App\Models\City::dropdown(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hotel</label>
                                <select name="hotel_id" onchange="add_new_hotel(this)" class="form-control form-control-sm select2">
                                    <option value="">Select Hotel</option>
                                    <option value="new">Add New</option>
                                    <?php echo \App\Models\Hotel::dropdown(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Checkin</label>
                                <input type="text" name="checkin" class="form-control form-control-sm date" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nights<span class="text-danger">*</span></label>
                                <input type="text" name="nights" class="form-control form-control-sm" placeholder="0">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Checkout</label>
                                <input type="text" name="checkout" class="form-control form-control-sm date" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Room Type</label>
                                <select name="room_type" class="form-control form-control-sm select2">
                                    <option value="">Select Room</option>
                                    <?php echo \App\Models\RoomType::dropdown(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">#of Rooms</label>
                                <input type="text" name="no_room" class="form-control form-control-sm" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Total Capacity<span class="text-danger">*</span></label>
                                <input type="text" name="total_capacity" class="form-control form-control-sm" placeholder="Enter Capacity">
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Purchsed By</label>
                                <select name="purchased_by" class="form-control form-control-sm select2">
                                    <option value="">--Select--</option>
                                    <?php echo App\Models\Accounts\TransactionAccount::vendor_dd(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Currency</label>
                                <select name="currency" class="form-control form-control-sm select2">
                                    <option value="">--Currency--</option>
                                    <?php echo \App\Models\Currency::dropdown(); ?>

                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Currency Rate</label>
                                <input type="text" name="currency_rate" class="form-control form-control-sm" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Purchase Rate</label>
                                <input type="text" name="purchase_rate" class="form-control form-control-sm" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <hr style="margin: 0px 0px 0px 0px !important;">
                    <div class="more-item"></div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_rec()">Save</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/umrah/reservations/hotel_reservation/modal.blade.php ENDPATH**/ ?>