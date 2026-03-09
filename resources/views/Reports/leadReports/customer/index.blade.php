<?php
/**
 * Created by PhpStorm.
 * User: TOSHIBA
 * Date: 29-Jan-22
 * Time: 6:45 PM
 */
?>
@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Reports</li>
                            <li class="breadcrumb-item">Lead Reports</li>
                            <li class="breadcrumb-item active">Customer Reports</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Customer Reports</h3><br>
                            <form action="{{ url('reports/lead_reports/customer_report') }}" method="post" target="_blank">
                                @CSRF
                            <div class="row">
                                    <div class="col-md-2 form-group">
                                        <input type="text" name="" class="form-control form-control-sm date" placeholder="Date From">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="text" name="" class="form-control form-control-sm date" placeholder="Date to">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-print"></i> </button>
                                    </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.card-header -->
                    {{--<div class="card-body">--}}
                    {{--<table id="example2" class="table table-striped">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                    {{--<th>Lead Number</th>--}}
                    {{--<th>Client Name</th>--}}
                    {{--<th>Lead Status</th>--}}
                    {{--<th>Created By</th>--}}
                    {{--<th>Taken By</th>--}}
                    {{--<th>Total</th>--}}
                    {{--<th>Payment</th>--}}
                    {{--<th>Balance</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody id="get_data"></tbody>--}}
                    {{--</table>--}}
                    {{--</div>--}}
                    <!-- /.card-body -->
                        {{--<div class="card-footer clearfix">--}}
                        {{--<div class="pagination-panel"></div>--}}
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
@endsection<!-- jQuery -->