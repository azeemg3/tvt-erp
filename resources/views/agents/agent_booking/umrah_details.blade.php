@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('public/css/lead.css') }}">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Crm</li>
                            <li class="breadcrumb-item">Umrah Agent</li>
                            <li class="breadcrumb-item active">Booking Details</li>
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
                            <div class="row invoice-info">
                                <div class="row" id="flight-details">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Flight Details</h3>
                                                @if($flight->status==1)
                                                    <a href="{{ url('agent_management/agent_umrah') }}/{{ $flight->id }}" target="_blank" class="btn btn-primary float-right"><i class="fa fa-print"> Print Voucher</i></a>
                                                @endif
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <h6 class="col-md-12">Arrival Details:</h6>
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>PNR</th>
                                                                <th>Flight#</th>
                                                                <th>Departure</th>
                                                                <th>Arrival</th>
                                                                <th>Arrival Sector</th>
                                                                <th>Termial</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <td>{{ $flight->pnr }}</td>
                                                            <td>{{ $flight->arr_flight }}</td>
                                                            <td>{{ $flight->arr_dep_date }} {{ $flight->arr_dep_time }}</td>
                                                            <td>{{ $flight->arr_date }} {{ $flight->arr_time }}</td>
                                                            <td>{{ $flight->arr_sector }}</td>
                                                            <td>{{ $flight->city_name }}</td>
                                                            </tbody>
                                                        </table>
                                                    </div><!--col-md-12-->
                                                    <h6 class="col-md-12">Departure Details:</h6>
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Flight#</th>
                                                                <th>Departure</th>
                                                                <th>Duration</th>
                                                                <th>Arrival Sector</th>
                                                                <th>Termial</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>{{ $flight->arr_flight }}</td>
                                                                <td>{{ $flight->dep_date }}{{ $flight->dep_dime }}</td>
                                                                <td>{{ $flight->duration }}</td>
                                                                <td>{{ $flight->dep_sector }}</td>
                                                                <td>{{ $flight->dep_ter }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div><!--col-md-12-->
                                                </div><!--row-->
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Transport Details</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>From City</th>
                                                                <th>To City</th>
                                                                <th>Transport Type</th>
                                                                <th>#pax</th>
                                                                <th>#Vehicle</th>
                                                                <th>Rate</th>
                                                                <th>Net</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php
                                                                $total_transport=0;
                                                            @endphp
                                                            @foreach($transport as $item)
                                                                @php
                                                                    $total_transport+=$item->net_rate;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $item->transport_date }} {{ $item->transport_time }}</td>
                                                                    <td>{{ $item->from_city }}</td>
                                                                    <td>{{ $item->to_city }}</td>
                                                                    <td>{{ \App\Helpers\CommonHelper::get_veh_types($item->transport_type) }}</td>
                                                                    <td>{{ $item->no_pax }}</td>
                                                                    <td>{{ $item->vehicle }}</td>
                                                                    <td>{{ $item->rate }}</td>
                                                                    <td>{{ $item->net_rate }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div><!--col-md-12-->
                                                </div><!--row-->
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Hotel Details</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>City</th>
                                                                <th>Hotel</th>
                                                                <th>Room Type</th>
                                                                <th>#Room</th>
                                                                <th>#pax</th>
                                                                <th>Checkin</th>
                                                                <th>Nights</th>
                                                                <th>Checkout</th>
                                                                <th>Rate</th>
                                                                <th>Net</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $total_hotel=0; @endphp
                                                            @foreach($hotels as $hotel)
                                                                @php $total_hotel+=$hotel->net_rate; @endphp
                                                                <tr>
                                                                    <td>{{ $hotel->city_name }}</td>
                                                                    <td>{{ $hotel->hotel_name }}</td>
                                                                    <td>{{ \App\Helpers\CommonHelper::getroom_type($hotel->room_type) }}</td>
                                                                    <td>{{ $hotel->room }}</td>
                                                                    <td>{{ $hotel->no_pax }}</td>
                                                                    <td>{{ $hotel->checkin }}</td>
                                                                    <td>{{ $hotel->nights }}</td>
                                                                    <td>{{ $hotel->checkout }}</td>
                                                                    <td>{{ $hotel->rate }}</td>
                                                                    <td>{{ $hotel->net_rate }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div><!--col-md-12-->
                                                </div><!--row-->
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Pax Details</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Father Name</th>
                                                                <th>Middle Name</th>
                                                                <th>Last Name</th>
                                                                <th>Gender</th>
                                                                <th>Pax Type</th>
                                                                <th>DOB</th>
                                                                <th>CNIC</th>
                                                                <th>Nationlaity</th>
                                                                <th>Address</th>
                                                                <th>Rate</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php $total_visa=0; @endphp
                                                            @php $total_flight=0; @endphp
                                                            @foreach($pax as $pa)
                                                                @php $total_visa+=($pa->visa_rate)*($flight->conversion_rate); @endphp
                                                                @php $total_flight+=$pa->flight_price; @endphp
                                                                <tr>
                                                                    <td>{{ \App\Helpers\CommonHelper::get_pax_title($pa->title) }}
                                                                        {{ $pa->pax_name }}
                                                                    </td>
                                                                    <td>{{ $pa->father_name }}</td>
                                                                    <td>{{ $pa->middle_name }}</td>
                                                                    <td>{{ $pa->last_name }}</td>
                                                                    <td>{{ $pa->name }}</td>
                                                                    <td>
                                                                        @if($pa->gender==1) Male @endif
                                                                        @if($pa->gender==2) FeMale @endif
                                                                        @if($pa->gender==3) Other @endif
                                                                    </td>
                                                                    <td>{{ $pa->passport_expire_date }}</td>
                                                                    <td>{{ $pa->cnic }}</td>
                                                                    <td>{{ $pa->name }}</td>
                                                                    <td>{{ $pa->address }}</td>
                                                                    <td>{{ $pa->visa_rate }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="col-md-3 float-right">
                                                            <div class="card">
                                                                <!-- /.card-header -->
                                                                <div class="card-body p-0">
                                                                    <table class="table text-right">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td><strong>Transport:</strong></td>
                                                                            <td> {{ number_format($total_transport,2) }}</td>
                                                                        </tr>                                                                   <tr>
                                                                            <td><strong>Transport BRN:</strong></td>
                                                                            <td> {{ number_format($flight->transport_brn_price,2) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Hotel:</strong></td>
                                                                            <td>{{ number_format($total_hotel,2) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Hotel BRN:</strong></td>
                                                                            <td>{{ number_format($flight->hotel_brn_price,2) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Visa:</strong></td>
                                                                            <td> {{ number_format($total_visa,2) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Flight:</strong></td>
                                                                            <td>{{ number_format($total_flight,2) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Total:</strong></td>
                                                                            <td>{{ number_format(($total_transport)+($total_hotel)+($total_visa)+($total_flight)+
                                                                            ($flight->transport_brn_price)+($flight->hotel_brn_price),2) }}</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                            <!-- /.card -->
                                                        </div>
                                                    </div><!--col-md-12-->
                                                </div><!--row-->
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection