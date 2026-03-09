
<?php $__env->startSection('content'); ?>
    <style>
        .col-md-2{ max-width: 14.6666% !important; }
        .col-md-1{ max-width: 6.6666% !important; }
        .col-md-2, .col-md-1{ padding-right: 2px !important;; padding-left: 2px !important; }
        .card-header{ padding: 0.25rem 0.5rem; }
        .card-body{ padding: 0.75rem;}
        .hotel-box .col-md-2{ max-width: 12.666% !important; }
        .transport-box .col-md-2{ max-width: 11.666% !important; }
        .hotel-box .col-md-1{ max-width: 7.6666% !important; }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-info card-tabs">
                                        <div class="card-header p-0 pt-1">
                                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                <li class="nav-item acive">
                                                    <a  class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#umrah" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><i class="fa fa-kaaba"></i> Umrah</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <div id="umrah" class="tab-pane fade show active row">
                                                    <h5>Make Your Own Umrah Trip:</h5>
                                                    <form id="umrah-form">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="col-md-12 col-sm-12">
                                                            <div class="card card-primary card-outline card-outline-tabs">
                                                                <div class="card-header p-0 border-bottom-0">
                                                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                                                        <li class="nav-item">
                                                                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#umrah-services" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Umrah Services</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                                                        <div class="tab-pane fade active show" id="umrah-services" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="radio" id="radioPrimaryf1" name="flight" value="1" checked onclick="flight_det(this.value)">
                                                                                        <label for="radioPrimaryf1"> With Flight</label>
                                                                                    </div>
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="radio" id="radioPrimaryf2" name="flight" value="0" onclick="flight_det(this.value)">
                                                                                        <label for="radioPrimaryf2">Without Flight</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!--col-md-12-->
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="checkbox" id="visacheck" name="trip_includes[]" value="visa" checked>
                                                                                        <label for="visacheck">Visa</label>
                                                                                    </div>
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="checkbox" id="hotelcheck" name="trip_includes[]" value="hotel" checked>
                                                                                        <label for="hotelcheck">Hotel</label>
                                                                                    </div>
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="checkbox" id="transportcheck" name="trip_includes[]" value="transport" checked>
                                                                                        <label for="transportcheck">Transport</label>
                                                                                    </div>
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="checkbox" id="transportvisacheck" name="trip_includes[]" value="transport_visa">
                                                                                        <label for="transportvisacheck">Transprt Include in Visa</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!--col-md-12-->
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Select Agent</label>
                                                                                        <select name="agentID" id="edit_agentID" class="form-control form-control-sm select2" onchange="fetch_agent_groups(this.value)">
                                                                                            <option value="">Select Agent</option>
                                                                                            <?php echo App\Models\Accounts\Agent::dropdown(); ?>


                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <!--col-->
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Group Number</label>
                                                                                        <select name="group_no" class="form-control form-control-sm select2 agent_group" onchange="fetch_agent_visitors(this)">
                                                                                            <option value="">Select Group No</option>
                                                                                            <?php echo App\Models\Umrah\GroupDetail::dropdown(); ?>

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <!--col-->
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <label>Conversion Rate</label>
                                                                                        <input type="text" class="form-control form-control-sm" id="conversion_rate" name="conversion_rate" value="<?php echo e($conversion_rate); ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <!--col-->
                                                                            </div>
                                                                            <div class="row" id="flight-details">
                                                                                <div class="col-md-12">
                                                                                    <div class="card">
                                                                                        <div class="card-header">
                                                                                            <h3 class="card-title">Flight Details</h3>
                                                                                        </div>
                                                                                        <!-- /.card-header -->
                                                                                        <div class="card-body">
                                                                                            <div class="row">
                                                                                                <h6 class="col-md-12">Arrival Details:</h6>
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>PNR</label>
                                                                                                        <input type="text" class="form-control form-control-sm" autocomplete="off" name="pnr" value="">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Flight#</label>
                                                                                                        <input type="text" class="form-control form-control-sm" autocomplete="off" name="arr_flight" value="">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Departure Date</label>
                                                                                                    <input type="text" class="form-control form-control-sm date" name="arr_dep_date" value="">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Dep Time</label>
                                                                                                    <input type="text" autocomplete="off" class="form-control form-control-sm datetimepicker-input" name="arr_dep_time" data-target="#timepicker" data-toggle="datetimepicker" value="">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Arrival Date</label>
                                                                                                    <input type="text" id="dep_arr" class="form-control form-control-sm date" name="arr_date" value="">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Arr Time</label>
                                                                                                    <input type="text" autocomplete="off" class="form-control form-control-sm" name="arr_time" value="">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <label>Arr Sector</label>
                                                                                                    <input type="text" class="form-control form-control-sm" name="arr_sector" value="">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Terminal</label>
                                                                                                        <select class="form-control form-control-sm select2" name="arr_terminal">
                                                                                                            <option value="">Enter City Name</option>
                                                                                                            <?php echo App\Models\City::dropdown(); ?>

                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->

                                                                                            </div><!--row-->
                                                                                            <div class="row">
                                                                                                <h6 class="col-md-12">Departure Details:</h6>
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Flight#</label>
                                                                                                        <input type="text" class="form-control form-control-sm" autocomplete="off" name="dep_flight" value="">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Departure Date</label>
                                                                                                    <input type="text" id="dep_date" class="form-control form-control-sm date" name="dep_date" value="">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <label>Dep Time</label>
                                                                                                    <input type="text" autocomplete="off" class="form-control form-control-sm" name="dep_dime" value="">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <label>Duration</label>
                                                                                                    <input type="number" id="duration" class="form-control form-control-sm" name="duration" value="">
                                                                                                </div>
                                                                                                <!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Arrival Date</label>
                                                                                                    <input type="text" id="dep_arr" class="form-control form-control-sm date" name="dep_arr_date">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Arr Time</label>
                                                                                                    <input type="text" autocomplete="off" class="form-control form-control-sm" name="dep_arr_time">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Departure Sector</label>
                                                                                                    <input type="text" class="form-control form-control-sm" name="dep_sector" value="">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Terminal</label>
                                                                                                        <select class="form-control form-control-sm select2" name="dep_terminal">
                                                                                                            <option value="">Enter Terminal</option>
                                                                                                            <?php echo App\Models\City::dropdown(); ?>

                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                            </div><!--row-->
                                                                                        </div>
                                                                                        <!-- /.card-body -->
                                                                                    </div>
                                                                                    <!-- /.card -->
                                                                                </div>
                                                                            </div> <!-- end row -->
                                                                            <div class="row hotel-box">
                                                                                <div class="col-md-12">
                                                                                    <div class="card">
                                                                                        <div class="card-header">
                                                                                            <h3 class="card-title">Enter Hotel Details</h3>
                                                                                        </div>
                                                                                        <!-- /.card-header -->
                                                                                        <div class="card-body">
                                                                                            <div class="row">
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label style="font-size: 12px;">Arrangement</label>
                                                                                                        <select class="form-control form-control-sm arrangement" name="arrangement[]">
                                                                                                            <option value="1">Operator</option>
                                                                                                            <option value="2">Agent</option>
                                                                                                            <option value="3">Self</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>City</label>
                                                                                                        <select class="form-control form-control-sm select2" onchange="get_agnt_hotel(this)" name="city[]">
                                                                                                            <option value="">Enter City Name</option>
                                                                                                            <?php echo App\Models\City::ksa_cityList(); ?>

                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Hotel</label>
                                                                                                        <select class="form-control form-control-sm select2 hotel" name="hotel_id[]">
                                                                                                            <option value="">Enter Hotel Name</option>
                                                                                                            <?php echo App\Models\Hotel::agentHotel(); ?>

                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Room Type</label>
                                                                                                        <select class="form-control form-control-sm select2 room_type" name="room_type[]">
                                                                                                            <option value="0">Select Room Type</option>
                                                                                                            <?php echo App\Helpers\CommonHelper::room_type(); ?>

                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1" style="max-width: 5% !important;">
                                                                                                    <div class="form-group">
                                                                                                        <label>Room</label>
                                                                                                        <input class="room form-control form-control-sm room" placeholder="0" onchange="hotel_cal(this),room_types(this)" name="room[]" value="1">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1" style="max-width: 7% !important;">
                                                                                                    <div class="form-group">
                                                                                                        <label>No of Pax</label>
                                                                                                        <input class="form-control form-control-sm no_pax" placeholder="0" name="no_pax[]" value="1">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Checkin</label>
                                                                                                        <input class="form-control form-control-sm checkin date" name="checkin[]" value="">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Nights</label>
                                                                                                        <input class="form-control form-control-sm nights" placeholder="0" onchange="get_next_date(this)" value="0" name="nights[]">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Checkout</label>
                                                                                                        <input class="form-control form-control-sm date checkout" name="checkout[]" value="">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Rate</label>
                                                                                                        <input type="text" class="form-control form-control-sm hotel_rate" readonly name="hotel_rate[]" value="">
                                                                                                        <input type="hidden" class="form-control form-control-sm HRID" name="HRID[]" value="">
                                                                                                        <input type="hidden" class="form-control form-control-sm hotel_cost" name="hotel_cost[]" value="">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Net</label>
                                                                                                        <input class="form-control form-control-sm hotel_net" readonly name="hnet_rate[]" value="">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label style="visibility: hidden">Netahafkh</label>
                                                                                                        <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                                                                                            <button type="button" class="btn btn-sm btn-primary" onclick="more_hotel(this)"><i class="fa fa-plus"></i> </button>
                                                                                                            <button style="width: 90px" type="button" class="btn btn-warning" onclick="search_hotel_option(this)">Search Option</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                            </div><!--row-->
                                                                                            <div class="more-hotels"></div>
                                                                                        </div>
                                                                                        <!-- /.card-body -->
                                                                                    </div>
                                                                                    <!-- /.card -->
                                                                                </div>
                                                                            </div> <!-- end row -->
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="card">
                                                                                        <div class="card-header">
                                                                                            <h3 class="card-title">Enter Transport Details</h3>
                                                                                        </div>
                                                                                        <!-- /.card-header -->
                                                                                        <div class="card-body transport-box">
                                                                                            <div class="row">
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Arrangement</label>
                                                                                                        <select class="form-control form-control-sm arrangement" name="arrangement[]">
                                                                                                            <option value="1">Operator</option>
                                                                                                            <option value="2">Agent</option>
                                                                                                            <option value="3">Self</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Date</label>
                                                                                                        <input type="text" class="form-control form-control-sm date" autocomplete="off" name="transport_date[]" value="">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <label>Time</label>
                                                                                                    <input type="text" autocomplete="off" class="form-control form-control-sm" name="transport_time[]" value="">
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>From City</label>
                                                                                                        <select class="form-control form-control-sm select2 from_city" name="from_city[]" onchange="transport_rate(this)">
                                                                                                            <option value="">Enter City Name</option>
                                                                                                            <?php echo App\Models\Crm\UmrahTransportCity::dropdown(); ?>

                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->

                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>To City</label>
                                                                                                        <select class="form-control form-control-sm select2 to_city" name="to_city[]" onchange="transport_rate(this)">
                                                                                                            <option value="">Enter City Name</option>
                                                                                                            <?php echo App\Models\Crm\UmrahTransportCity::dropdown(); ?>

                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Transport Type</label>
                                                                                                        <select class="form-control form-control-sm select2 transport_type" onchange="transport_rate(this)" name="transport_type[]">
                                                                                                            <option value="">Select Type</option>
                                                                                                            <?php echo App\Helpers\CommonHelper::vehicle_types(); ?>

                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>No of Pax</label>
                                                                                                        <input class="form-control form-control-sm no_of_pax" placeholder="0" name="no_pax[]" onchange="transport_cal(this)" value="1">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Vehicle</label>
                                                                                                        <input class="form-control form-control-sm no_vehcile" placeholder="0" onchange="transport_cal(this)" name="vehicle[]" value="1">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Rate</label>
                                                                                                        <input class="form-control form-control-sm transport_rate" readonly name="trans_rate[]" value="">
                                                                                                        <input type="hidden" class="form-control form-control-sm TRID" readonly name="TRID[]" value="">
                                                                                                        <input type="hidden" class="form-control form-control-sm transport_cost" readonly name="transport_cost[]" value="">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Net</label>
                                                                                                        <input class="form-control form-control-sm transport_net" value="" readonly name="net_rate[]">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label style="visibility: hidden">Netahafkh</label>
                                                                                                        <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                                                                                            <button type="button" class="btn btn-sm btn-primary" onclick="more_transport(this)"><i class="fa fa-plus"></i> </button>
                                                                                                            <button style="width: 90px" type="button" onclick="search_transport_option(this)" class="btn btn-warning">Search Option</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                            </div><!--row-->
                                                                                            <div class="more-transports"></div>
                                                                                        </div>
                                                                                        <!-- /.card-body -->
                                                                                    </div>
                                                                                    <!-- /.card -->
                                                                                </div>
                                                                            </div> <!-- end row -->
                                                                            <div class="">
                                                                                <div class="col-md-12">
                                                                                    <div class="card">
                                                                                        <div class="card-header">
                                                                                            <h3 class="card-title">Ground Handling Services</h3>
                                                                                        </div>
                                                                                        <!-- /.card-header -->
                                                                                        <div class="card-body">
                                                                                            <div class="row">
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Services</label>
                                                                                                        <select class="form-control form-control-sm select2" onchange="ground_service(this.value)" name="ground_handle_product">
                                                                                                            <option value="">Select Service</option>
                                                                                                            <?php echo \App\Models\Crm\GroundHandleRate::dropdown(); ?>

                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Price (optional)</label>
                                                                                                        <input class="form-control form-control-sm" name="ground_price">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-12">
                                                                                                    <textarea class="form-control textarea" placeholder="Other Information" name=""></textarea>
                                                                                                </div>
                                                                                            </div><!--row-->
                                                                                        </div>
                                                                                        <!-- /.card-body -->
                                                                                    </div>
                                                                                    <!-- /.card -->
                                                                                </div>
                                                                            </div> <!-- end row -->
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="card">
                                                                                        <div class="card-header">
                                                                                            <h3 class="card-title">Pax Details</h3>
                                                                                        </div>
                                                                                        <!-- /.card-header -->
                                                                                        <div class="card-body">
                                                                                            <div class="row">
                                                                                                <div class="col-md-12">
                                                                                                    <button type="button" onclick="add_new_pax()" class="row btn btn-primary btn-xs btn-flat float-right">Add New</button>
                                                                                                </div>
                                                                                                <table class="table">
                                                                                                    <thead>
                                                                                                    <tr>
                                                                                                        <th>#</th>
                                                                                                        <th>Name</th>
                                                                                                        <th>Nationality</th>
                                                                                                        <th>Date of Birth</th>
                                                                                                        <th>Age</th>
                                                                                                        <th>Passport</th>
                                                                                                        <th>Visa Price</th>
                                                                                                        <th>Flight Price</th>
                                                                                                        <th>Group Leader</th>
                                                                                                        <th>Action</th>
                                                                                                    </tr>
                                                                                                    </thead>
                                                                                                    <tbody id="get_pax_data"></tbody>
                                                                                                </table>
                                                                                            </div><!--row-->
                                                                                        </div>
                                                                                        <!-- /.card-body -->
                                                                                    </div>
                                                                                    <!-- /.card -->
                                                                                </div>
                                                                            </div> <!-- end row -->
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <textarea class="form-control" name="remarks" placeholder="Remarks"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div><!--tab-pane-->
                                                                    </div>
                                                                </div><!--card-body-->
                                                            </div><!-- /.card -->
                                                        </div><!--col-md-12-->
                                                        <div class="col-md-3 float-right">
                                                            <div class="card">
                                                                <!-- /.card-header -->
                                                                <div class="card-body">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <td colspan="2" align="center">Expected Price In Pkr</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Transport:</th>
                                                                            <td><span id="transport_total"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Hotel:</th>
                                                                            <td><span id="hotel_total"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Visa</th>
                                                                            <td><span id="total_visa"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Flight</th>
                                                                            <td><span id="total_flight"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Total:</th>
                                                                            <td><span id="total"></span></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <!-- /.card-body -->
                                                                <div class="card-footer">
                                                                    <button type="button" class="btn btn-warning" onclick="save_umrah_rec()">Send for Process</button>
                                                                    <button type="button" onclick="save_umrah_rec(1)" class="btn btn-danger">Save as Draft</button>
                                                                </div>
                                                            </div>
                                                            <!-- /.card -->
                                                        </div>
                                                    </form>
                                                </div><!-- end tab-pane -->
                                            </div>
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php echo $__env->make('agents.agent_booking.umrah-pax-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
    <?php echo $__env->make('agents.agent_booking.group-pax-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
    <?php echo $__env->make('agents.agent_booking.agent_umra_jsFunc', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('agents.agent_booking.search-transport-option-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('agents.agent_booking.search-hotel-option-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\new-projects\htdocs\uotrips\resources\views/agents/agent_booking/create.blade.php ENDPATH**/ ?>