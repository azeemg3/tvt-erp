@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Umrah</li>
                            <li class="breadcrumb-item active">Group Details</li>
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
                                    <th><i class="fa fa-user"></i> Mutamer</th>
                                    <th>#Visa</th>
                                    <th>Nationality</th>
                                    <th>DOB</th>
                                    <th>Age</th>
                                    <th>Passport</th>
                                    <th>Groups</th>
                                    <th>Gender</th>
                                    <th>Img</th>
                                    <th>Passport Img</th>
                                    <th>Vaccine Certificate</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Muhamad Azeem</td>
                                        <td>V9877</td>
                                        <td>Pakitan</td>
                                        <td>10-03-1990</td>
                                        <td>32</td>
                                        <td>SC1151893</td>
                                        <td>714693</td>
                                        <td>Male</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="#"><i class="fa fa-edit"></i></a>
                                            <a class="btn btn-xs btn-default" href="#"><i class="fa fa-print"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
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
    @include('umrah.mofa.modal')
    @include('umrah.group_details.js_func')
    {{--<script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>--}}
    <script>
        function add_new() {
            $("#new").modal();
            $(".select2").select2();
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