@extends('layouts.app')
@section('content')
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
                                                        <input type="hidden" name="UID" value="{{ $result->id }}">
                                                        {{--<input type="hidden" name="agentID" id="edit_agentID" value="{{ $result->created_by }}">--}}
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
                                                                                        <input type="radio" id="radioPrimaryf1" name="flight" @if($result->flight==1) checked @endif value="1" checked onclick="flight_det(this.value)">
                                                                                        <label for="radioPrimaryf1"> With Flight</label>
                                                                                    </div>
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="radio" id="radioPrimaryf2" @if($result->flight==0) checked @endif name="flight" value="0" onclick="flight_det(this.value)">
                                                                                        <label for="radioPrimaryf2">Without Flight</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!--col-md-12-->
                                                                            @php
                                                                                $includes=explode(',',$result->trip_includes);
                                                                            @endphp
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="checkbox" id="visacheck" name="trip_includes[]" @if(in_array("visa",$includes)) checked @endif>
                                                                                        <label for="visacheck">Visa</label>
                                                                                    </div>
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="checkbox" id="hotelcheck" name="trip_includes[]" @if(in_array("hotel",$includes)) checked @endif>
                                                                                        <label for="hotelcheck">Hotel</label>
                                                                                    </div>
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="checkbox" id="transportcheck" name="trip_includes[]" @if(in_array("transport",$includes)) checked @endif>
                                                                                        <label for="transportcheck">Transport</label>
                                                                                    </div>
                                                                                    <div class="icheck-primary d-inline">
                                                                                        <input type="checkbox" id="transportvisacheck" name="trip_includes[]" name="" @if(in_array("transport_visa",$includes)) checked @endif>
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
                                                                                            {!! App\Models\Accounts\Agent::dropdown(App\Models\Accounts\Agent::where('UID',$result->created_by)->value('id')) !!}

                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <!--col-->
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label>Group Number</label>
                                                                                        <select name="group_no" class="form-control form-control-sm select2 agent_group" onchange="fetch_agent_visitors(this)">
                                                                                            <option value="">Select Group No</option>
                                                                                            {!! App\Models\Umrah\GroupDetail::dropdown($result->group_no) !!}
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <!--col-->
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <label>Conversion Rate</label>
                                                                                        <input type="text" name="conversion_rate" class="form-control form-control-sm" id="conversion_rate" value="{{ $conversion_rate }}">
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
                                                                                                        <input type="text" class="form-control form-control-sm" autocomplete="off" name="pnr" value="{{ $result->pnr }}">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Flight#</label>
                                                                                                        <input type="text" class="form-control form-control-sm" autocomplete="off" name="arr_flight" value="{{ $result->arr_flight }}">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Departure Date</label>
                                                                                                    <input type="text" class="form-control form-control-sm date" name="arr_dep_date" value="{{ $result->arr_dep_date }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Dep Time</label>
                                                                                                    <input type="text" autocomplete="off" class="form-control form-control-sm datetimepicker-input" name="arr_dep_time" data-target="#timepicker" data-toggle="datetimepicker" value="{{ $result->arr_dep_time }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Arrival Date</label>
                                                                                                    <input type="text" id="dep_arr" class="form-control form-control-sm date" name="arr_date" value="{{ $result->arr_date }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Arr Time</label>
                                                                                                    <input type="text" autocomplete="off" class="form-control form-control-sm" name="arr_time" value="{{ $result->arr_time }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <label>Arr Sector</label>
                                                                                                    <input type="text" class="form-control form-control-sm" name="arr_sector" value="{{ $result->arr_sector }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Terminal</label>
                                                                                                        <select class="form-control form-control-sm select2" name="arr_terminal">
                                                                                                            <option value="">Enter City Name</option>
                                                                                                            {!! App\Models\City::dropdown($result->arr_terminal) !!}
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div><!--col-->

                                                                                            </div><!--row-->
                                                                                            <div class="row">
                                                                                                <h6 class="col-md-12">Departure Details:</h6>
                                                                                                <div class="col-md-1">
                                                                                                    <div class="form-group">
                                                                                                        <label>Flight#</label>
                                                                                                        <input type="text" class="form-control form-control-sm" autocomplete="off" name="dep_flight" value="{{ $result->dep_flight }}">
                                                                                                    </div>
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Departure Date</label>
                                                                                                    <input type="text" id="dep_date" class="form-control form-control-sm date" name="dep_date" value="{{ $result->dep_date }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <label>Dep Time</label>
                                                                                                    <input type="text" autocomplete="off" class="form-control form-control-sm" name="dep_dime" value="{{ $result->dep_dime }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-1">
                                                                                                    <label>Duration</label>
                                                                                                    <input type="number" id="duration" class="form-control form-control-sm" name="duration" value="{{ $result->duration }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Arrival Date</label>
                                                                                                    <input type="text" id="dep_arr" class="form-control form-control-sm date" name="dep_arr_date" value="{{ $result->dep_arr_date }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Arr Time</label>
                                                                                                    <input type="text" autocomplete="off" class="form-control form-control-sm" name="dep_arr_time" value="{{ $result->dep_arr_time }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <label>Departure Sector</label>
                                                                                                    <input type="text" class="form-control form-control-sm" name="dep_sector" value="{{ $result->dep_sector }}">
                                                                                                </div><!--col-->
                                                                                                <div class="col-md-2">
                                                                                                    <div class="form-group">
                                                                                                        <label>Terminal</label>
                                                                                                        <select class="form-control form-control-sm select2" name="dep_terminal">
                                                                                                            <option value="">Enter Terminal</option>
                                                                                                            {!! App\Models\City::dropdown($result->dep_terminal) !!}
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
                                                                                            @php $hotel_net=0; @endphp
                                                                                            @foreach($hotels as $hotel)
                                                                                                <div class="row">
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label style="font-size: 12px;">Arrangement</label>
                                                                                                            <select class="form-control form-control-sm arrangement" name="arrangement[]">
                                                                                                                <option value="1" @if($hotel->arrangement==1) selected @endif>Operator</option>
                                                                                                                <option value="2" @if($hotel->arrangement==2) selected @endif>Agent</option>
                                                                                                                <option value="3" @if($hotel->arrangement==3) selected @endif>Self</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-2">
                                                                                                        <div class="form-group">
                                                                                                            <label>City</label>
                                                                                                            <select class="form-control form-control-sm select2" name="city[]">
                                                                                                                <option value="">Enter City Name</option>
                                                                                                                {!! App\Models\City::ksa_cityList($hotel->city) !!}
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-2">
                                                                                                        <div class="form-group">
                                                                                                            <label>Hotel</label>
                                                                                                            <select class="form-control form-control-sm select2 hotel" name="hotel_id[]">
                                                                                                                <option value="">Enter Hotel Name</option>
                                                                                                                {!! App\Models\Hotel::dropdown($hotel->hotel_id) !!}
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>Room Type</label>
                                                                                                            <select class="form-control form-control-sm select2 room_type" name="room_type[]">
                                                                                                                <option value="0">Select Room Type</option>
                                                                                                                {!! App\Helpers\CommonHelper::room_type($hotel->room_type) !!}
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1" style="max-width: 5% !important;">
                                                                                                        <div class="form-group">
                                                                                                            <label>Room</label>
                                                                                                            <input class="room form-control form-control-sm room" placeholder="0" onchange="hotel_cal(this),room_types(this)" name="room[]" value="{{ $hotel->room }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1" style="max-width: 7% !important;">
                                                                                                        <div class="form-group">
                                                                                                            <label>No of Pax</label>
                                                                                                            <input class="form-control form-control-sm no_pax" placeholder="0" name="no_pax[]" value="{{ $hotel->no_pax }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>Checkin</label>
                                                                                                            <input class="form-control form-control-sm checkin date" name="checkin[]" value="{{ $hotel->checkin }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>Nights</label>
                                                                                                            <input class="form-control form-control-sm nights" placeholder="0" onchange="get_next_date(this)" value="{{ $hotel->nights }}" name="nights[]">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>Checkout</label>
                                                                                                            <input class="form-control form-control-sm date checkout" name="checkout[]" value="{{ $hotel->checkout }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>Rate</label>
                                                                                                            <input type="text" class="form-control form-control-sm hotel_rate" readonly name="hotel_rate[]" value="{{ $hotel->rate }}">
                                                                                                            <input type="hidden" class="form-control form-control-sm HRID" name="HRID[]" value="{{ $hotel->HRID }}">
                                                                                                            <input type="hidden" class="form-control form-control-sm hotel_cost" name="hotel_cost[]" value="{{ $hotel->hotel_cost }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>Net</label>
                                                                                                            <input class="form-control form-control-sm hotel_net" readonly name="hnet_rate[]" value="{{ $hotel->net_rate }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label style="visibility: hidden">Netahafkh</label>
                                                                                                            <button type="button" class="btn btn-sm btn-primary" onclick="more_hotel(this)"><i class="fa fa-plus"></i> </button>
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                </div><!--row-->
                                                                                                <?php $hotel_net+=$hotel->net_rate; ?>
                                                                                            @endforeach
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
                                                                                            <?php $transport_net=0; ?>
                                                                                            @foreach($transports as $transport)
                                                                                                <div class="row">
                                                                                                    <div class="col-md-2">
                                                                                                        <div class="form-group">
                                                                                                            <label>Arrangement</label>
                                                                                                            <select class="form-control form-control-sm arrangement" name="arrangement[]">
                                                                                                                <option value="1" @if($transport->arrangement==1) selected @endif>Operator</option>
                                                                                                                <option value="2" @if($transport->arrangement==2) selected @endif>Agent</option>
                                                                                                                <option value="3" @if($transport->arrangement==3) selected @endif>Self</option>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-2">
                                                                                                        <div class="form-group">
                                                                                                            <label>Date</label>
                                                                                                            <input type="text" class="form-control form-control-sm date" autocomplete="off" name="transport_date[]" value="{{ $transport->transport_date }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <label>Time</label>
                                                                                                        <input type="text" autocomplete="off" class="form-control form-control-sm" name="transport_time[]" value="{{ $transport->transport_time }}">
                                                                                                    </div>
                                                                                                    <div class="col-md-2">
                                                                                                        <div class="form-group">
                                                                                                            <label>From City</label>
                                                                                                            <select class="form-control form-control-sm select2 from_city" name="from_city[]" onchange="transport_rate(this)">
                                                                                                                <option value="">Enter City Name</option>
                                                                                                                {!! App\Models\Crm\UmrahTransportCity::dropdown($transport->from_city) !!}
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div><!--col-->

                                                                                                    <div class="col-md-2">
                                                                                                        <div class="form-group">
                                                                                                            <label>To City</label>
                                                                                                            <select class="form-control form-control-sm select2 to_city" name="to_city[]" onchange="transport_rate(this)">
                                                                                                                <option value="">Enter City Name</option>
                                                                                                                {!! App\Models\Crm\UmrahTransportCity::dropdown($transport->to_city) !!}
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-2">
                                                                                                        <div class="form-group">
                                                                                                            <label>Transport Type</label>
                                                                                                            <select class="form-control form-control-sm select2 transport_type" onchange="transport_rate(this)" name="transport_type[]">
                                                                                                                <option value="">Select Type</option>
                                                                                                                {!! App\Helpers\CommonHelper::vehicle_types($transport->transport_type) !!}
                                                                                                            </select>
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>No of Pax</label>
                                                                                                            <input class="form-control form-control-sm no_of_pax" placeholder="0" name="no_pax[]" onchange="transport_cal(this)" value="{{ $transport->no_pax }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>Vehicle</label>
                                                                                                            <input class="form-control form-control-sm no_vehcile" placeholder="0" onchange="transport_cal(this)" name="vehicle[]" value="{{ $transport->vehicle }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>Rate</label>
                                                                                                            <input class="form-control form-control-sm transport_rate" readonly name="trans_rate[]" value="{{ $transport->rate }}">
                                                                                                            <input type="hidden" class="form-control form-control-sm TRID" readonly name="TRID[]" value="{{ $transport->TRID }}">
                                                                                                            <input type="hidden" class="form-control form-control-sm transport_cost" readonly name="transport_cost[]" value="{{ $transport->transport_cost }}">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label>Net</label>
                                                                                                            <input class="form-control form-control-sm transport_net" value="{{ $transport->net_rate }}" readonly name="net_rate[]">
                                                                                                        </div>
                                                                                                    </div><!--col-->
                                                                                                    <div class="col-md-1">
                                                                                                        <div class="form-group">
                                                                                                            <label style="visibility: hidden">Netahafkh</label>
                                                                                                            <button type="button" class="btn btn-sm btn-primary" onclick="more_transport(this)"><i class="fa fa-plus"></i> </button>
                                                                                                        </div>
                                                                                                    </div><!--col-->

                                                                                                </div><!--row-->
                                                                                                <?php $transport_net+=$transport->net_rate; ?>
                                                                                            @endforeach
                                                                                            <div class="more-transports"></div>
                                                                                        </div>
                                                                                        <!-- /.card-body -->
                                                                                    </div>
                                                                                    <!-- /.card -->
                                                                                </div>
                                                                            </div> <!-- end row -->

                                                                            <div class="hotel-box">
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
                                                                                                            {!! \App\Models\Crm\GroundHandleRate::dropdown($result->ground_handle_product) !!}
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
                                                                                                    <textarea class="form-control textarea" placeholder="Other Information" name="">{{ $result->other_ground_information}}</textarea>
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
                                                                                                    <tbody id="get_pax_data">
                                                                                                    @php $i=1 @endphp
                                                                                                    <?php $visa_net=0; $flight_net=0; ?>
                                                                                                    @foreach($paxes as $pax)
                                                                                                        <tr>
                                                                                                            <td>{{ $i }}</td>
                                                                                                            <td>{{ $pax->pax_name }}</td>
                                                                                                            <td>{{ $pax->country->name }}</td>
                                                                                                            <td>{{ $pax->dob }}</td>
                                                                                                            <td>{{ $pax->age }}</td>
                                                                                                            <td>{{ $pax->passport }}</td>
                                                                                                            <td>{{ $pax->visa_rate }}<input type="hidden" class="visa_price" value="{{ $pax->visa_rate }}"></td>
                                                                                                            <td>{{ $pax->flight_price }}</td>
                                                                                                            <td><input type="radio" name="group_leader" @if($pax->group_leader==1) checked @endif value="{{ $pax->pax_name }}"></td>
                                                                                                            <td>
                                                                                                                <a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_pax('{{ $pax->passport }}')"><i class="fa fa-edit"></i> </a>
                                                                                                                <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec('{{ $pax->passport }}', '{{ url('crm/save_umrah_pax/remove') }}/{{ $pax->passport }}')"><i class="fa fa-trash"></i> </a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        @php $i++ @endphp
                                                                                                        <?php
                                                                                                        $visa_net+=$pax->visa_rate;
                                                                                                        $flight_net+=$pax->flight_price;
                                                                                                        ?>
                                                                                                    @endforeach
                                                                                                    </tbody>
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
                                                                                    <label>Remarks</label>
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
                                                                            <td><span id="transport_total">{{ $transport_net*$conversion_rate }}</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Hotel:</th>
                                                                            <td><span id="hotel_total">{{ $hotel_net*$conversion_rate }}</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Visa</th>
                                                                            <td><span id="total_visa">{{ $visa_net*$conversion_rate }}</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Flight</th>
                                                                            <td><span id="total_flight">{{ $flight_net*$conversion_rate }}</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Total:</th>
                                                                            <td><span id="total">{{ (($hotel_net)+($transport_net)+($visa_net)+($flight_net))*$conversion_rate }}</span></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <!-- /.card-body -->
                                                                <div class="card-footer">
                                                                    <button type="button" class="btn btn-warning" onclick="update_umrah_rec({{ $result->id }})">Send for Process</button>
                                                                    <button type="button" onclick="update_umrah_rec(1)" class="btn btn-danger">Save as Draft</button>
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
    @include('agents.agent_booking.umrah-pax-modal');
    @include('agents.agent_booking.group-pax-modal');
    @include('agents.agent_booking.agent_umra_jsFunc')
@endsection