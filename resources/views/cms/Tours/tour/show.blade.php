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
                            <li class="breadcrumb-item">Bookings</li>
                            <li class="breadcrumb-item active">Tour Booking Details</li>
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
                                <div class="row" id="flight-details">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">{{ $result->pkg_name }}</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <h6 class="col-md-12">Package Details:</h6>
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Duration</th>
                                                                <th>Validity#</th>
                                                                <th>Departure Details</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>{{ $result->duration }} Nights</td>
                                                                <td>
                                                                    {{ date('d-m-Y',strtotime($result->validity_from)) }}/
                                                                    {{ date('d-m-Y',strtotime($result->validity_to)) }}
                                                                </td>
                                                                <td>{{ $result->departure_details }}</td>
                                                            </tr>
                                                            </tbody>

                                                        </table>
                                                    </div><!--col-md-12-->
                                                    <h6 class="col-md-12">Highlights:</h6>
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td>{!! $result->highlights !!}</td>
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
                                                <h3 class="card-title">Explore Details:</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <tbody>
                                                            {!! $result->explore_details !!}
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
                                                <h3 class="card-title">For Your Info:</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                @php
                                                    $your_info=json_decode($result->your_info,true);
                                                @endphp
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>Details</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($your_info as $info)

                                                                <tr>
                                                                    <td>{{ $info['title'] }}</td>
                                                                    <td>{!! $info['info_detail'] !!} </td>
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
                                    <!--col-->
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Price Details:</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                @php
                                                    $your_info=json_decode($result->your_info,true);
                                                @endphp
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Visa Price</th>
                                                                <td>{{ $result->adult_visa_price }}</td>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                        @php
                                                            $transports=json_decode($result->transports,true);
                                                        @endphp
                                                    </div>
                                                    <!--col-md-12-->
                                                </div><!--row-->
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>
                                    <!--col-->
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