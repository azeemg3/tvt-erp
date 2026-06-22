@extends('layouts.app')

@section('content')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Accounts</li>
                            <li class="breadcrumb-item active">Transaction A/C List</li>
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
                            <div class="mb-2 text-right">
                                <button type="button" class="btn btn-xs btn-dark" onclick="add_new()">Add New</button>
                            </div>
                            <table class="table table-bordered table-hover data-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Trnsaction A/C Name</th>
                                    <th>Subhead A/C Name</th>
                                    <th>Current Balance</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
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
    @include('Accounts.trans_accounts.modal')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
    <script>
        var table;

        (function initTransAccountsDatatable() {
            if (typeof window.jQuery === 'undefined' || !jQuery.fn || !jQuery.fn.DataTable) {
                return setTimeout(initTransAccountsDatatable, 150);
            }

            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ url('Accounts/get_trans_accounts') }}",
                    type: "GET"
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'code', name: 'transaction_accounts.code'},
                    {data: 'Trans_Acc_Name', name: 'transaction_accounts.Trans_Acc_Name'},
                    {data: 'subhead_name', name: 'subhead_name'},
                    {data: 'balance', name: 'balance', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                pageLength: 25,
                order: [[1, 'asc']]
            });
        })();

        function reload_table() {
            if (table) {
                table.ajax.reload();
            }
        }

        function add_new() {
            $("#new").modal();
            $(".select2").select2();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#form input[name~='code']").val('');
            $("#new").find('.btn-success').text('Submit');
        }
        function fetch_next_code() {
            var pid = $("#form select[name~='PID']").val();
            if (!pid) {
                $("#form input[name~='code']").val('');
                return;
            }
            $.ajax({
                url: "{{ url('Accounts/next_trans_account_code') }}",
                data: { PID: pid },
                dataType: "JSON",
                success: function (data) {
                    $("#form input[name~='code']").val(data.code);
                }
            });
        }
        $(document).on('change', "#form select[name~='PID']", function () {
            if ($("#form input[name~='id']").val() == 0) {
                fetch_next_code();
            }
        });
        function save_rec() {
            $("#loader").show();
            $.ajax({
                url:"{{ route('trans_accounts.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serialize(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#new").modal('hide');
                    reload_table();
                    $("#loader").hide();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
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
                url: "{{ url('Accounts/trans_accounts') }}/" + id + "/edit",
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
