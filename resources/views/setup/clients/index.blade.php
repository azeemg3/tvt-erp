@extends('layouts.app')

@section('content')
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">Client List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item">Setup Account</li>
                            <li class="breadcrumb-item active">Clients</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="card-title pt-1">Clients</h3>
                            <div class="card-tools">
                                <a href="{{ route('clients.export.excel') }}" class="btn btn-success btn-xs">
                                    <i class="fa fa-file-excel"></i> Excel
                                </a>
                                <a href="{{ route('clients.export.pdf') }}" class="btn btn-danger btn-xs">
                                    <i class="fa fa-file-pdf"></i> PDF
                                </a>
                                @can('client_create')
                                    <a href="{{ route('clients.create') }}" class="btn btn-dark btn-xs">
                                        <i class="fa fa-plus"></i> Add Client
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            @include('setup.partials.flash')
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped data-table w-100">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client Code</th>
                                        <th>Client Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Category</th>
                                        <th>Credit Limit</th>
                                        <th>Recovery Officer</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <form id="delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js" defer></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        var table;
        (function initClientsDatatable() {
            if (typeof window.jQuery === 'undefined' || !jQuery.fn || !jQuery.fn.DataTable) {
                return setTimeout(initClientsDatatable, 150);
            }
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('clients.data') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'client_code', name: 'clients.client_code'},
                    {data: 'client_name', name: 'clients.client_name'},
                    {data: 'mobile', name: 'clients.mobile'},
                    {data: 'email', name: 'clients.email'},
                    {data: 'category', name: 'clients.category'},
                    {data: 'credit_limit', name: 'clients.credit_limit'},
                    {data: 'recovery_officer', name: 'recovery_officer'},
                    {data: 'status_badge', name: 'clients.status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[0, 'asc']],
                pageLength: 25
            });
        })();

        function reload_table() {
            if (table) { table.ajax.reload(null, false); }
        }

        function toggle_status(url) {
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'JSON',
                success: function () {
                    toastr.success('Status updated.');
                    reload_table();
                },
                error: function () { toastr.error('Unable to update status.'); }
            });
        }

        function del_client(id) {
            if (!confirm('Are you sure you want to delete this client?')) { return; }
            var form = document.getElementById('delete-form');
            form.action = "{{ url('clients') }}/" + id;
            $.ajax({
                url: "{{ url('clients') }}/" + id,
                type: 'POST',
                data: {_method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content')},
                dataType: 'JSON',
                success: function () {
                    toastr.success('Client deleted successfully.');
                    reload_table();
                },
                error: function () { toastr.error('Unable to delete client.'); }
            });
        }
    </script>
@endsection
