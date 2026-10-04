@extends('layouts.app')

@section('content')
    <style>
        #report-area {
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
            background: #fff;
            min-height: calc(100vh - 240px);
            display: flex;
            flex-direction: column;
        }
        .pos-top-header { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .pos-top-header td { vertical-align: top; border: none; padding: 0; }
        .pos-logo img { max-width: 110px; max-height: 70px; }
        .pos-company-name {
            font-size: 18px;
            font-weight: 700;
            color: #1a3a8a;
            margin: 0 0 2px;
            text-align: center;
        }
        .pos-report-title {
            font-size: 13px;
            font-weight: 700;
            margin: 0 0 2px;
            text-align: center;
        }
        .pos-print-meta {
            width: 100%;
            font-size: 11px;
            margin: 6px 0 8px;
            border-collapse: collapse;
        }
        .pos-print-meta td { border: none; padding: 0; }
        .pos-currency {
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .pos-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 14px;
        }
        .pos-table thead th {
            background: #d9d9d9;
            border: 1px solid #9a9a9a;
            padding: 4px 3px;
            font-size: 9px;
            font-weight: 700;
            text-align: center;
            vertical-align: middle;
        }
        .pos-table tbody td {
            border: 1px solid #b0b0b0;
            padding: 3px 4px;
            vertical-align: middle;
        }
        .pos-table .text-right { text-align: right; white-space: nowrap; }
        .pos-table .text-center { text-align: center; }
        .pos-table .neg { color: #c00000; font-weight: 700; }
        .pos-table .total-row td {
            background: #d9d9d9;
            font-weight: 700;
            border: 1px solid #9a9a9a;
        }
        .pos-table .empty-row td {
            text-align: center;
            color: #777;
            padding: 12px;
        }
        .pos-activity-title {
            background: #cfcfcf !important;
            font-size: 10px !important;
        }
        .report-actions .btn { margin-right: 6px; margin-bottom: 6px; }
        .btn-excel { background-color: #17a2b8; border-color: #17a2b8; color: #fff; }
        .btn-word { background-color: #007bff; border-color: #007bff; color: #fff; }
        .btn-pdf { background-color: #dc3545; border-color: #dc3545; color: #fff; }
        .btn-email { background-color: #fff; border-color: #007bff; color: #007bff; }
        .btn-print-report { background-color: #8b1538; border-color: #8b1538; color: #fff; }
        .report-footer {
            border-top: 1px solid #ccc;
            margin-top: auto;
            padding-top: 8px;
            font-size: 10px;
            color: #555;
        }
        .report-footer table { width: 100%; border-collapse: collapse; }
        .report-footer td { border: none; }
        @media print {
            .no-report { display: none !important; }
            div.report-show { display: block !important; }
            table.report-show, table.pos-table, table.pos-top-header, table.pos-print-meta { display: table !important; }
            .content-wrapper { margin: 0 !important; padding: 0 !important; }
            .main-footer, .main-header, .main-sidebar, .card { border: none !important; box-shadow: none !important; }
            .card-body { padding: 0 !important; }
            @page { size: landscape; margin: 8mm 8mm 14mm 8mm; }
            .pos-table { font-size: 8px; }
            #report-area { min-height: auto; display: block; padding-bottom: 28px; }
            .report-footer {
                position: fixed;
                left: 0; right: 0; bottom: 0;
                margin-top: 0;
                background: #fff;
                padding: 6px 0 0;
            }
        }
    </style>

    <div class="content-wrapper">
        <section class="content-header no-report">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item">Clients Report</li>
                    <li class="breadcrumb-item active">Client Position Report</li>
                </ol>
            </div>
        </section>

        <section class="content">
            <div class="card rounded-0">
                <div class="card-body">
                    <form id="form" class="no-report">
                        <div class="row">
                            <div class="col-md-2">
                                <input type="text" name="df" id="df" class="form-control form-control-sm date" placeholder="From Date">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="dt" id="dt" class="form-control form-control-sm date" placeholder="To Date">
                            </div>
                            <div class="col-md-3">
                                <select name="ledger" class="form-control form-control-sm select2">
                                    <option value="">All Clients</option>
                                    {!! App\Models\Accounts\TransactionAccount::client_dd() !!}
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="category" class="form-control form-control-sm">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-flat btn-xs btn-dark" onclick="get_data()">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>

                    <div id="report-area" class="mt-3">
                        <table class="pos-top-header report-show" id="report_header">
                            <tr>
                                <td style="width:18%;">
                                    <div class="pos-logo">
                                        <img src="{{ $company->logo_url }}" alt="Logo" onerror="this.style.display='none'">
                                    </div>
                                </td>
                                <td style="width:64%;">
                                    <div class="pos-company-name">{{ $company->name }}</div>
                                    <div class="pos-report-title">
                                        Client Position Report For the period From
                                        <span id="display_from">-</span> To <span id="display_to">-</span>
                                    </div>
                                </td>
                                <td style="width:18%;"></td>
                            </tr>
                        </table>

                        <table class="pos-print-meta report-show">
                            <tr>
                                <td style="width:40%;">Print By : <span id="print_by">{{ Auth::user()->name ?? '' }}</span></td>
                                <td style="width:30%; text-align:center;">Print On : <span id="print_on"></span></td>
                                <td style="width:30%; text-align:right;">Category : <span id="category_label">All</span></td>
                            </tr>
                        </table>

                        <div class="pos-currency report-show">
                            <span id="currency_code">PKR</span> &nbsp; <span id="currency_name">Pak Rupees</span>
                        </div>

                        <table id="table2excel" class="pos-table report-show">
                            <thead>
                            <tr>
                                <th rowspan="2">Client Account</th>
                                <th rowspan="2">Client Name</th>
                                <th rowspan="2">Contact No.</th>
                                <th rowspan="2">Opening Bal.<br>On <span id="open_label">-</span></th>
                                <th colspan="7" class="pos-activity-title">Activity during the period</th>
                                <th rowspan="2">Closing Bal.<br>Of <span id="close_label">-</span></th>
                            </tr>
                            <tr>
                                <th>Invoice</th>
                                <th>Debit Note</th>
                                <th>Void/Refund</th>
                                <th>Bookings</th>
                                <th>Cancellations</th>
                                <th>Receipts</th>
                                <th>Payments</th>
                            </tr>
                            </thead>
                            <tbody id="report_body">
                            <tr class="empty-row"><td colspan="12">Select filters and run the report.</td></tr>
                            </tbody>
                        </table>

                        <div class="report-actions no-report">
                            <button type="button" class="btn btn-sm btn-excel exportToExcel"><i class="fa fa-file-excel"></i> Excel</button>
                            <button type="button" class="btn btn-sm btn-word exportToWord"><i class="fa fa-file-word"></i> Word</button>
                            <button type="button" class="btn btn-sm btn-pdf" onclick="exportPdf()"><i class="fa fa-file-pdf"></i> PDF</button>
                            <button type="button" class="btn btn-sm btn-email" onclick="emailReport()"><i class="fa fa-envelope"></i> Email</button>
                            <button type="button" id="printDiv" class="btn btn-sm btn-print-report"><i class="fa fa-print"></i> Print</button>
                        </div>

                        <div class="report-footer report-show" id="report_footer">
                            <table>
                                <tr>
                                    <td style="text-align:left;">Copyright &copy; {{ date('Y') }} {{ $company->name }}.</td>
                                    <td style="text-align:center;">@if(!empty($company->website))Website: {{ $company->website }}@endif</td>
                                    <td style="text-align:right;">{{ $company->powered_by ?: 'All rights reserved.' }}</td>
                                </tr>
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
            setDefaultDates();
            updatePrintMeta();
        });

        function setDefaultDates() {
            var today = new Date();
            var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            var isoFmt = function (d) {
                return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);
            };
            if (!$('#df').val()) $('#df').val(isoFmt(firstDay));
            if (!$('#dt').val()) $('#dt').val(isoFmt(today));
            syncDateLabels();
        }

        function syncDateLabels() {
            var fromDisp = formatDateDisplay($('#df').val());
            var toDisp = formatDateDisplay($('#dt').val());
            $('#display_from').text(fromDisp);
            $('#display_to').text(toDisp);
            $('#open_label').text(fromDisp);
            $('#close_label').text(toDisp);
        }

        function formatDateDisplay(dateStr) {
            if (!dateStr) return '-';
            var parts = String(dateStr).substring(0, 10).split('-');
            if (parts.length === 3) return parts[2] + '/' + parts[1] + '/' + parts[0];
            return dateStr;
        }

        function formatNumber(num) {
            num = parseFloat(num) || 0;
            if (Math.abs(num) < 0.005) return '0.00';
            var text = Math.abs(num).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (num < 0) return '<span class="neg">(' + text + ')</span>';
            return text;
        }

        function updatePrintMeta(name) {
            var now = new Date();
            var pad = function (n) { return ('0' + n).slice(-2); };
            $('#print_on').text(pad(now.getDate()) + '/' + pad(now.getMonth() + 1) + '/' + now.getFullYear());
            if (name) $('#print_by').text(name);
        }

        function get_data() {
            $("#loader").show();
            syncDateLabels();

            $.ajax({
                url: "{{ url('reports/client/get_client_position_report') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'JSON',
                data: $("#form").serialize(),
                success: function (data) {
                    updatePrintMeta(data.printed_by);
                    $('#category_label').text(data.category_label || 'All');
                    if (data.currency) $('#currency_code').text(data.currency);
                    if (data.currency_name) $('#currency_name').text(data.currency_name);
                    if (data.opening_label) $('#open_label').text(data.opening_label);
                    if (data.closing_label) $('#close_label').text(data.closing_label);

                    var rows = data.rows || [];
                    var html = '';
                    if (!rows.length) {
                        html = '<tr class="empty-row"><td colspan="12">No client position activity for selected filters.</td></tr>';
                    } else {
                        for (var i = 0; i < rows.length; i++) {
                            var r = rows[i];
                            html += '<tr>';
                            html += '<td class="text-center">' + (r.client_account || '') + '</td>';
                            html += '<td>' + (r.client_name || '') + '</td>';
                            html += '<td class="text-center">' + (r.contact_no || '') + '</td>';
                            html += '<td class="text-right">' + formatNumber(r.opening_balance) + '</td>';
                            html += '<td class="text-right">' + formatNumber(r.invoice) + '</td>';
                            html += '<td class="text-right">' + formatNumber(r.debit_note) + '</td>';
                            html += '<td class="text-right">' + formatNumber(r.void_refund) + '</td>';
                            html += '<td class="text-right">' + formatNumber(r.bookings) + '</td>';
                            html += '<td class="text-right">' + formatNumber(r.cancellations) + '</td>';
                            html += '<td class="text-right">' + formatNumber(r.receipts) + '</td>';
                            html += '<td class="text-right">' + formatNumber(r.payments) + '</td>';
                            html += '<td class="text-right">' + formatNumber(r.closing_balance) + '</td>';
                            html += '</tr>';
                        }
                        var t = data.totals || {};
                        html += '<tr class="total-row">';
                        html += '<td colspan="3" class="text-right">Client Receivable :</td>';
                        html += '<td class="text-right">' + formatNumber(t.opening_balance) + '</td>';
                        html += '<td class="text-right">' + formatNumber(t.invoice) + '</td>';
                        html += '<td class="text-right">' + formatNumber(t.debit_note) + '</td>';
                        html += '<td class="text-right">' + formatNumber(t.void_refund) + '</td>';
                        html += '<td class="text-right">' + formatNumber(t.bookings) + '</td>';
                        html += '<td class="text-right">' + formatNumber(t.cancellations) + '</td>';
                        html += '<td class="text-right">' + formatNumber(t.receipts) + '</td>';
                        html += '<td class="text-right">' + formatNumber(t.payments) + '</td>';
                        html += '<td class="text-right">' + formatNumber(t.closing_balance) + '</td>';
                        html += '</tr>';
                    }
                    $('#report_body').html(html);
                    $("#loader").hide();
                },
                error: function (xhr) {
                    $("#loader").hide();
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to load report.';
                    toastr.error(msg);
                }
            });
        }

        function exportPdf() {
            var $form = $('<form>', {
                method: 'POST',
                action: "{{ url('reports/client/pdf_client_position_report') }}",
                target: '_blank'
            });
            $form.append($('<input>', { type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content') }));
            $form.append($('<input>', { type: 'hidden', name: 'df', value: $('input[name="df"]').val() }));
            $form.append($('<input>', { type: 'hidden', name: 'dt', value: $('input[name="dt"]').val() }));
            $form.append($('<input>', { type: 'hidden', name: 'ledger', value: $('select[name="ledger"]').val() }));
            $form.append($('<input>', { type: 'hidden', name: 'category', value: $('select[name="category"]').val() }));
            $form.appendTo('body').submit().remove();
        }

        function emailReport() {
            var subject = encodeURIComponent('Client Position Report - {{ $company->name }}');
            var body = encodeURIComponent(
                'Please find the Client Position Report.\n\nFrom: ' +
                $('#display_from').text() + '\nTo: ' + $('#display_to').text()
            );
            window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
        }

        $('#printDiv').on('click', function () { window.print(); });

        $(document).on('click', '.exportToExcel', function () {
            $("#table2excel").table2excel({
                exclude: ".noExl",
                name: "Client Position Report",
                filename: "client_position_report_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                fileext: ".xls",
                preserveColors: true
            });
        });

        $(document).on('click', '.exportToWord', function () {
            var header = document.getElementById('report_header').outerHTML;
            var meta = document.querySelector('.pos-print-meta').outerHTML;
            var currency = document.querySelector('.pos-currency').outerHTML;
            var table = document.getElementById('table2excel').outerHTML;
            var footer = document.getElementById('report_footer').outerHTML;
            var html = '<html><head><meta charset="utf-8"></head><body>' + header + meta + currency + table + footer + '</body></html>';
            var blob = new Blob(['\ufeff', html], {type: 'application/msword'});
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'client_position_report_' + new Date().toISOString().slice(0, 10) + '.doc';
            link.click();
        });
    </script>
@endpush
