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
                            <li class="breadcrumb-item">User Management</li>
                            <li class="breadcrumb-item active">User List</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover data-table">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>User Status</th>
                                    <th width="280px">Action</th>
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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
    <script>
        (function initUsersDatatable() {
            if (typeof window.jQuery === 'undefined' || !jQuery.fn || !jQuery.fn.DataTable) {
                return setTimeout(initUsersDatatable, 150);
            }

            var usersTable = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('users.data') }}",
                    type: "GET",
                    error: function (xhr, error, thrown) {
                        var msg = 'Data load failed. HTTP ' + xhr.status + ' - ' + (xhr.responseText ? xhr.responseText.substring(0, 200) : thrown);
                        if (typeof toastr !== 'undefined') {
                            toastr.error(msg);
                        } else {
                            alert(msg);
                        }
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'roles', name: 'roles', orderable: false},
                    {data: 'user_status', name: 'user_status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                pageLength: 25,
                language: {
                    emptyTable: "No users found or data source not reachable."
                },
                order: [[1, 'asc']]
            });

            usersTable.on('xhr.dt', function (e, settings, json, xhr) {
                if (!json || typeof json.data === 'undefined') {
                    var raw = xhr && xhr.responseText ? xhr.responseText.substring(0, 200) : 'No response body';
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Unexpected response format from users.data: ' + raw);
                    } else {
                        alert('Unexpected response format from users.data: ' + raw);
                    }
                }
            });
        })();
    </script>
@endsection<!-- jQuery -->