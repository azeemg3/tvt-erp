@extends('layouts.app')

@section('content')
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark" style="font-size:1.4rem;">Airline List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item">Application Setup</li>
                            <li class="breadcrumb-item active">Airlines</li>
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
                            <h3 class="card-title pt-1">Airlines</h3>
                            <div class="card-tools">
                                <a href="{{ route('airlines.export.excel') }}" class="btn btn-success btn-xs">
                                    <i class="fa fa-file-excel"></i> Excel
                                </a>
                                <a href="{{ route('airlines.export.pdf') }}" class="btn btn-danger btn-xs">
                                    <i class="fa fa-file-pdf"></i> PDF
                                </a>
                                @can('airline_create')
                                    <a href="{{ route('airlines.create') }}" class="btn btn-dark btn-xs">
                                        <i class="fa fa-plus"></i> Add Airline
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
                                        <th>Airline Name</th>
                                        <th>IATA</th>
                                        <th>ICAO</th>
                                        <th>Numeric Code</th>
                                        <th>Country</th>
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
        (function initAirlinesDatatable() {
            if (typeof window.jQuery === 'undefined' || !jQuery.fn || !jQuery.fn.DataTable) {
                return setTimeout(initAirlinesDatatable, 150);
            }
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ route('airlines.data') }}",
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'airlines.name'},
                    {data: 'iata_code', name: 'airlines.iata_code'},
                    {data: 'icao_code', name: 'airlines.icao_code'},
                    {data: 'numeric_code', name: 'airlines.numeric_code'},
                    {data: 'country_name', name: 'country_name'},
                    {data: 'status_badge', name: 'airlines.status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[1, 'asc']],
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

        function del_airline(id) {
            if (!confirm('Are you sure you want to delete this airline?')) { return; }
            $.ajax({
                url: "{{ url('Application_Setup/airlines') }}/" + id,
                type: 'POST',
                data: {_method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content')},
                dataType: 'JSON',
                success: function () {
                    toastr.success('Airline deleted successfully.');
                    reload_table();
                },
                error: function () { toastr.error('Unable to delete airline.'); }
            });
        }
    </script>
@endsection
