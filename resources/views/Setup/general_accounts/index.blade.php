@extends('layouts.app')

@section('content')
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">General Account List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item">Setup Account</li>
                            <li class="breadcrumb-item active">General Accounts</li>
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
                            <h3 class="card-title pt-1">General Accounts</h3>
                            <div class="card-tools">
                                @can('general_account_create')
                                    <a href="{{ route('general-accounts.create') }}" class="btn btn-dark btn-xs">
                                        <i class="fa fa-plus"></i> Add General Account
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
                                        <th>Name</th>
                                        <th>NIC</th>
                                        <th>City</th>
                                        <th>Phone</th>
                                        <th>Roles</th>
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

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js" defer></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        var table;
        (function initGeneralAccountsDatatable() {
            if (typeof window.jQuery === 'undefined' || !jQuery.fn || !jQuery.fn.DataTable) {
                return setTimeout(initGeneralAccountsDatatable, 150);
            }
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('general_accounts.data') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'nic', name: 'nic'},
                    {data: 'city', name: 'city'},
                    {data: 'phone', name: 'phone'},
                    {data: 'role_badges', name: 'role_badges', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[0, 'asc']],
                pageLength: 25
            });
        })();

        function reload_table() {
            if (table) { table.ajax.reload(null, false); }
        }

        function del_general_account(id) {
            if (!confirm('Are you sure you want to delete this general account?')) { return; }
            $.ajax({
                url: "{{ url('general-accounts') }}/" + id,
                type: 'POST',
                data: {_method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content')},
                dataType: 'JSON',
                success: function () {
                    toastr.success('General Account deleted successfully.');
                    reload_table();
                },
                error: function () { toastr.error('Unable to delete general account.'); }
            });
        }
    </script>
@endsection
