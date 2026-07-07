@extends('layouts.app')

@section('content')
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">Supplier / Vendor List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item">Setup Account</li>
                            <li class="breadcrumb-item active">Vendors</li>
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
                            <h3 class="card-title pt-1">Vendors</h3>
                            <div class="card-tools">
                                <a href="{{ route('vendors.export.excel') }}" class="btn btn-success btn-xs">
                                    <i class="fa fa-file-excel"></i> Excel
                                </a>
                                <a href="{{ route('vendors.export.pdf') }}" class="btn btn-danger btn-xs">
                                    <i class="fa fa-file-pdf"></i> PDF
                                </a>
                                @can('vendor_create')
                                    <a href="{{ route('vendors.create') }}" class="btn btn-dark btn-xs">
                                        <i class="fa fa-plus"></i> Add Vendor
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
                                        <th>Vendor Code</th>
                                        <th>Vendor Name</th>
                                        <th>Vendor Type</th>
                                        <th>Contact Person</th>
                                        <th>Mobile</th>
                                        <th>Credit Limit</th>
                                        <th>Credit Days</th>
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

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js" defer></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js" defer></script>
    <script>
        var table;
        (function initVendorsDatatable() {
            if (typeof window.jQuery === 'undefined' || !jQuery.fn || !jQuery.fn.DataTable) {
                return setTimeout(initVendorsDatatable, 150);
            }
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: "{{ route('vendors.data') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'vendor_code', name: 'vendor_code'},
                    {data: 'vendor_name', name: 'vendor_name'},
                    {data: 'vendor_type', name: 'vendor_type'},
                    {data: 'contact_person', name: 'contact_person'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'credit_limit', name: 'credit_limit'},
                    {data: 'credit_days', name: 'credit_days'},
                    {data: 'status_badge', name: 'status'},
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

        function del_vendor(id) {
            if (!confirm('Are you sure you want to delete this vendor?')) { return; }
            $.ajax({
                url: "{{ url('vendors') }}/" + id,
                type: 'POST',
                data: {_method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content')},
                dataType: 'JSON',
                success: function () {
                    toastr.success('Vendor deleted successfully.');
                    reload_table();
                },
                error: function () { toastr.error('Unable to delete vendor.'); }
            });
        }
    </script>
@endsection
