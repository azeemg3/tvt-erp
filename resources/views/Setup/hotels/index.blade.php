@extends('layouts.app')
@section('content')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        .hotel-page .hotel-card {
            border: 1px solid #e9ecef;
            box-shadow: 0 0.15rem 0.8rem rgba(17, 24, 39, 0.06);
        }
        .hotel-page .hotel-card .card-header {
            background: #ffffff;
            border-bottom: 1px solid #edf1f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.9rem 1rem;
        }
        .hotel-page .hotel-title {
            font-size: 1.05rem;
            font-weight: 600;
            margin: 0;
            color: #1f2937;
        }
        .hotel-page .hotel-subtitle {
            margin: 0.1rem 0 0;
            font-size: 0.8rem;
            color: #6b7280;
        }
        .hotel-page .hotel-table thead th {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            color: #374151;
            white-space: nowrap;
        }
        .hotel-page .hotel-table tbody td {
            vertical-align: middle;
        }
        .hotel-page .hotel-actions .btn {
            min-width: 32px;
        }
        .hotel-page div.dataTables_wrapper div.dataTables_filter input {
            border: 1px solid #d1d5db;
            border-radius: 0.2rem;
            height: 30px;
            padding: 0 8px;
        }
        .hotel-page .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #111827 !important;
            border-color: #111827 !important;
            color: #fff !important;
        }
        .hotel-page .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #374151 !important;
            border-color: #374151 !important;
            color: #fff !important;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper hotel-page">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Application Setup</li>
                            <li class="breadcrumb-item active">Hotels</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0 hotel-card">
                        <div class="card-header">
                            <div>
                                <h3 class="hotel-title">Hotel Listing</h3>
                                <p class="hotel-subtitle">Manage hotel details with quick edit and delete actions.</p>
                            </div>
                            <button class="btn btn-sm btn-dark" onclick="add_new()">
                                <i class="fa fa-plus mr-1"></i> Add Hotel
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover hotel-table data-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
    @include('Setup.hotels.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
    <script>
        var table;
        function add_new() {
            $("#new").modal();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
        }
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('Application_Setup/get_hotels') }}",
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'hotel_name', name: 'hotel_name'},
                    {data: 'country_name', name: 'country_name'},
                    {data: 'action', name: 'action', searchable: false, orderable: false},
                ],
                order: [[1, 'asc']],
                pageLength: 15,
                lengthMenu: [[10, 15, 25, 50], [10, 15, 25, 50]]
            });

        });
        function save_rec() {
            $("#loader").show();
            $.ajax({
                url:"{{ route('hotel.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serialize(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#new").modal('hide');
                    table.ajax.reload(null, false);
                    $("#loader").hide();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        }
        function edit(id) {
            $("#new").modal();
            $.ajax({
                url: "{{ url('Application_Setup/hotel') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data).length; i++){
                        $("#form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    }
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                }
            })
        }
    </script>
@endsection