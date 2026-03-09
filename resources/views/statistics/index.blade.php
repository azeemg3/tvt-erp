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
                            <li class="breadcrumb-item">Statistics</li>
                            <li class="breadcrumb-item active">Statistic</li>
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
                                                @foreach($province as $item)
                                                    <li class="nav-item">
                                                        <a onclick="get_ticket_invoice(1)" class="nav-link @if($item->name=='Punjab') active @endif" id="custom-tabs-one-home-tab" data-toggle="pill" href="#{{ $item->name }}" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><i class="fa fa-map-marker"></i> {{ $item->name }}</a>
                                                    </li>
                                                    @endforeach
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                @foreach($province as $item)
                                                <div class="tab-pane fade show @if($item->name=='Punjab') active @endif" id="{{ $item->name }}" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                    <h5>{{ $item->name }} Statistics</h5>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr class="table-active">
                                                            <th>#</th>
                                                            <th>Division</th>
                                                            <th>Central</th>
                                                            <th>Districts</th>
                                                            <th>Cities</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="get_ticket_inv"></tbody>
                                                    </table>
                                                    <div class="card-footer clearfix">
                                                        <div class="pagination-panel"></div>
                                                    </div>
                                                </div>
                                                    @endforeach

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
@endsection