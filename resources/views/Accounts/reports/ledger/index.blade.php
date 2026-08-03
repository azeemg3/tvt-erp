@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Accounts</li>
                            <li class="breadcrumb-item active">Ledger Report</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-body">
                            <form id="form">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input name="df" id="df" class="form-control form-control-sm date" placeholder="Date From">
                                    </div>
                                    <div class="col-md-2">
                                        <input name="dt" id="dt" class="form-control form-control-sm date" placeholder="Date To">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control form-control-sm select2" name="ledger_id">
                                            <option value="">Select Ledger</option>
                                            {!! App\Models\Accounts\TransactionAccount::dropdown() !!}
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" id="btn_report_search" class="btn btn-xs btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <button class="btn btn-xs btn-primary float-right exportToExcel"><i class="fa fa-file-excel"> Export</i></button>
                            <table id="table2excel" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>VT</th>
                                    <th>Voucher</th>
                                    <th>Description</th>
                                    <th>Dr</th>
                                    <th>Cr</th>
                                    <th>Balance</th>
                                </tr>
                                </thead>
                                <tbody id="get_data"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ URL::asset('public/export_excel/jquery.table2excel.js') }}"></script>
    <script>
        bootstrapReportFilters('#form', function () {
            setReportDefaultDates('#df', '#dt');
            $('#btn_report_search').on('click', get_data);
        });

        function get_data() {
            var ledgerId = $('select[name="ledger_id"]').val();
            if (!ledgerId) {
                toastr.warning('Please select a ledger account.');
                return;
            }
            $("#loader").show();
            $.ajax({
                url: "{{ url('Accounts/reports/get_ledger') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data: {
                    df: $('input[name="df"]').val(),
                    dt: $('input[name="dt"]').val(),
                    ledger_id: ledgerId
                },
                dataType: "JSON",
                success: function (data) {
                    $("#get_data").html(data.data);
                    $("#loader").hide();
                },
                error: function (xhr) {
                    $("#loader").hide();
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to load ledger.';
                    toastr.error(msg);
                }
            });
        }

        $(document).on('click', '.exportToExcel', function () {
            $("#table2excel").table2excel({
                filename: "ledger_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                exclude: ".noExl",
                name: "Ledger",
                fileext: ".xls",
                preserveColors: true
            });
        });
    </script>
@endpush
