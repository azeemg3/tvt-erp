@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Ziarat Rate</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Application Setup</li>
                            <li class="breadcrumb-item">Rate Setup</li>
                            <li class="breadcrumb-item active">Ziarat Rate List</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>From City</th>
                                    <th>Ziarat City</th>
                                    <th>Contact Name</th>
                                    <th>Contact Number</th>
                                    <th>From Date</th>
                                    <th>Till Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        {{--<div class="card-footer clearfix">--}}
                        {{--<ul class="pagination pagination-sm m-0 float-right">--}}
                        {{--<li class="page-item"><a class="page-link" href="#">«</a></li>--}}
                        {{--<li class="page-item active"><a class="page-link" href="#">1</a></li>--}}
                        {{--<li class="page-item"><a class="page-link" href="#">»</a></li>--}}
                        {{--</ul>--}}
                        {{--</div>--}}
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('Rate_setup.ziarat_rate.modal')
    {{--<script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>--}}
    <script>
        function add_new() {
            $("#new").modal();
        }
        function more_item() {
            $(".more-item").append('<div class="row">' +
            '                <div class="form-group col-md-2">' +
                '                <select name="" class="form-control form-control-sm">' +
                '                <option value="">Select</option>' +
                '                </select>' +
                '                </div>' +
            '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Curr Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '            <input type="text" class="form-control form-control-sm" placeholder="Rate">' +
                '                </div>' +
                '                <div class="form-group col-md-1">' +
                '                <button type="button" class="btn btn-xs btn-danger" onclick="more_item()"><i class="fa fa-trash"></i> </button>' +
                '                </div>' +
                '                </div>');
        }
    </script>
@endsection<!-- jQuery -->