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
                            <li class="breadcrumb-item">Lms</li>
                            <li class="breadcrumb-item">Leads</li>
                            <li class="breadcrumb-item active">Lead Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if($status==1)
                        <div class="alert alert-success alert-dismissible rounded-0">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="fas fa-check"></i> Alert:<span class="lead">Lead Taken Over Successfully</span></h5>
                        </div>
                        @endif
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-user"></i> {{ $result[0]->contact_name }}
                                        <small class="float-right">Lead #{{ \App\Helpers\CommonHelper::dsn($result[0]->id) }}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col border-right">
                                    <address>
                                        <strong>Mobile No: </strong><span class="float-right">{{ $result[0]->mobile }}</span><br>
                                        <strong>Email: </strong><span class="float-right">{{ $result[0]->email }}</span><br>
                                        <strong>CNIC: </strong><span class="float-right">{{ $result[0]->cnic }}</span><br>
                                        <strong>Country: </strong><span class="float-right">{{ $result[0]->name }}</span><br>
                                        <strong>City: </strong><span class="float-right">{{ $result[0]->city }}</span><br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col border-right">
                                    <address>
                                        <strong>Traveling Date From: </strong><span class="float-right">{{ $result[0]->travel_date_from }}</span><br>
                                        <strong>Traveling Date To: </strong><span class="float-right">{{ $result[0]->travel_date_to }}</span><br>
                                        <strong>Sector: </strong><span class="float-right">{{ $result[0]->sector }}</span><br>
                                        <strong>Services: </strong><span class="float-right">{{ App\Helpers\CommonHelper::get_services($services) }}</span><br>
                                        <strong>Source Of Query: </strong><span class="float-right">{{ \App\Helpers\CommonHelper::get_query_source($result[0]->source_of_query) }}</span><br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <address>
                                        <strong>Created Date: </strong><span class="float-right">{{ $result[0]->created_at }}</span><br>
                                        <strong>Created By: </strong><span class="float-right">{{ $result[0]->created_by }}</span><br>
                                        <strong>Taken Over By: </strong><span class="float-right">Muhammad</span><br>
                                        <strong>Status: </strong><span class="float-right">{!! \App\Helpers\CommonHelper::lead_status($result[0]->status) !!}</span><br>
                                        <span class="ledger">
                                            @if($result[0]->ledger==0 || $result[0]->ledger==null)
                                            <button class="btn-xs btn btn-info btn-flat" onclick="get_lead_details()">Create Ledger</button></span><br>
                                            @endif
                                        @if($result[0]->ledger==1)
                                            {{--Ledger Request Sent--}}
                                            @endif
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">

                                </div>
                                <div class="col-md-12">
                                    <div class="callout callout-info rounded-0">
                                        <h5><i class="fas fa-info"></i> Details:</h5>
                                        {!! $result[0]->other_details !!}
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
                            @include('Lms.lead_conversation')
                            @if($result[0]->ledger!=0 || $result[0]->ledger!=null)
                            @include('Lms.sale')
                                @endif
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('Lms.js_func')
    @include('Lms.sales.sale_js_func')
    @include('Lms.ledger-modal')
@endsection