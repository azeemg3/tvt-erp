@extends('layouts.app')
@section('content')
    <style>
        .bg-lightblue a{ color: white;}
    </style>
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
                            <div class="btn-group float-right">
                                <span id="showing-entries"></span>
                                <button class="btn btn-xs btn-dark" onclick="add_new()">Add New</button>
                                <button class="btn btn-xs btn-primary" onclick="import_excel_group()"><i class="fa fa-file-excel"></i> Import Excel</button>
                                <button class="btn btn-xs btn-success" onclick="bulk_mutamer()"><i class="fa fa-file-excel"></i> Import Bulk Mutamers</button>
                            </div>
                            <form id="search-form">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <select name="agentID" class="form-control form-control-sm select2">
                                        <option value="">Select Agent</option>
                                        {!! \App\Models\Accounts\Agent::agent() !!}
                                    </select>
                                </div>
                                    <div class="col-md-3 form-group">
                                        <input type="text" name="group_name" class="form-control form-control-sm" placeholder="with Group Nmae" autocomplete="off">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <input type="text" name="group_code" class="form-control form-control-sm" placeholder="With Group Code" autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="get_data(1)"><i class="fa fa-search"></i> </button>
                                    </div>
                            </div>
                            </form>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Agent Name</th>
                                    <th>Country</th>
                                    <th>Group Code</th>
                                    <th>Group Name</th>
                                    <th>Embassy</th>
                                    <th>#Voucehr</th>
                                    <th>Amount</th>
                                    <th><i class="fa fa-user"></i> Mutamer</th>
                                    <th>#Mofa</th>
                                    <th><i class="fa fa-building"></i> </th>
                                    <th><i class="fa fa-car"></i> </th>
                                    <th>Gs</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data">
                                </tbody>
                            </table>
                        </div>
                        {{--<!-- /.card-body -->--}}
                        <div class="card-footer clearfix">
                            <div class="pagination-panel"></div>
                        </div>
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
    @include('umrah.visitors.modal')
    @include('umrah.group_details.group-excel-modal')
    @include('umrah.group_details.modal')
    @include('umrah.group_details.hotel_brn-modal')
    @include('umrah.group_details.transport_brn-modal')
    @include('umrah.reservations.hotel_reservation.modal')
    @include('umrah.reservations.transport_reservation.modal')
    @include('umrah.group_details.transport-company-modal')
    @include('umrah.group_details.mofa-modal')
    @include('umrah.group_details.ground_services-modal')
    @include ('umrah.ground_services.modal')
    @include('umrah.group_details.voucher_amount-modal')
    @include('Setup.hotels.modal')
    @include('cities.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @include('umrah.group_details.js_func')
<script>
    $(function () {
        $(".select2").select2();
    })
</script>
@endsection<!-- jQuery -->