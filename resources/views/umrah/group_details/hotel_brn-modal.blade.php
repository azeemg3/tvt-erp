<div class="modal" id="hotel_brn-modal">
    <div class="modal-dialog modal-xl">
        <form id="hotelBrn-form">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="GID" value="0">
            <div class="modal-content rounded-0">
                <!-- Modal Header -->
                <div class="modal-header rounded-0 bg-gradient-yellow">
                    <h5 class="modal-title">Hotel BRN</h5>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">BRN#</label>
                                <select name="HTBRN[]" class="form-control form-control-sm select2"
                                        id="fetch_hotel_brn" onchange="hotel_reservation(this), available_hotel_capacity(this)">
                                    <option value="">--Select--</option>
                                    <option value="new">Add New</option>
                                    {!! App\Models\Umrah\HotelReservationBrn::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Room Type</label>
                                <select readonly class="form-control form-control-sm room_type">
                                    <option value="">--Select--</option>
                                    {!! App\Models\RoomType::dropdown() !!}
                                </select>
                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">#Rooms</label>
                                <input type="text" name="no_pax[]" disabled class="form-control form-control-sm no_room" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">#Beds</label>
                                <input type="text" name="no_pax[]" disabled class="form-control form-control-sm no_beds" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="exampleInputEmail1">#of Pax</label>
                                <input type="text" name="no_pax[]" class="form-control form-control-sm no_pax" placeholder="Enter...">

                            </div>
                        </div>
                        <!--col-->
                        <div class="col-md-1">
                            <div class="form-group">
                                <label style="visibility: hidden;">Add Moree</label>
                                <button type="button" onclick="more_hotel_brn()" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> </button>
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <div class="more-hotel-brn"></div>
                    <hr style="margin: 0px 0px 0px 0px !important;">
                    <div class="more-item"></div>
                    <!-- Modal footer -->
                    <div class="clearfix"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success btn-xs" onclick="save_hotel_brn()">Save</button>
                        <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>