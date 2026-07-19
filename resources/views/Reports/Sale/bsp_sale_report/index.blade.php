@extends('layouts.app')

@section('content')
    <style>
        .bsp-report-header {
            font-family: Arial, sans-serif;
            margin-bottom: 10px;
        }
        .bsp-report-header .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .bsp-report-header .company-info {
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .bsp-report-title {
            font-size: 16px;
            font-weight: bold;
            margin: 6px 0 2px;
            text-align: center;
        }
        .bsp-report-dates {
            font-size: 12px;
            text-align: center;
            margin-bottom: 10px;
        }
        .bsp-report-print-date {
            font-size: 11px;
            text-align: right;
            color: #555;
        }
        #table2excel {
            font-size: 12px;
            border-collapse: collapse;
            width: 100%;
        }
        #table2excel thead th {
            background-color: #f1f3f5;
            border: 1px solid #adb5bd;
            padding: 6px 6px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        #table2excel tbody td {
            border: 1px solid #ced4da;
            padding: 4px 6px;
            vertical-align: middle;
        }
        #table2excel .text-right { text-align: right; }
        #table2excel .text-center { text-align: center; }
        #table2excel .group-title td {
            font-weight: bold;
            background-color: #f8f9fa;
            border: 1px solid #adb5bd;
        }
        #table2excel .branch-total td {
            font-weight: bold;
            background-color: #f1f3f5;
            border-top: 1px solid #495057;
        }
        #table2excel .net-total td {
            font-weight: bold;
            background-color: #e9ecef;
            border-top: 2px solid #212529;
            border-bottom: 2px solid #212529;
        }
        #table2excel .empty-row td {
            text-align: center;
            color: #868e96;
            padding: 14px;
        }
        .report-actions .btn { margin-right: 6px; margin-bottom: 6px; }
        .btn-excel { background-color: #17a2b8; border-color: #17a2b8; color: #fff; }
        .btn-word { background-color: #007bff; border-color: #007bff; color: #fff; }
        .btn-email { background-color: #fff; border-color: #007bff; color: #007bff; }
        .btn-print-report { background-color: #8b1538; border-color: #8b1538; color: #fff; }
        .report-footer {
            border-top: 1px solid #ccc;
            margin-top: 20px;
            padding-top: 10px;
            font-size: 11px;
            color: #555;
        }
        .report-footer table { width: 100%; }
        @media print {
            .no-report { display: none !important; }
            .report-show { display: block !important; }
            .content-wrapper { margin: 0 !important; padding: 0 !important; }
            .main-footer, .main-header, .main-sidebar { display: none !important; }
            @page { size: landscape; margin: 8mm; }
            #table2excel { font-size: 10px; }
            #table2excel thead th,
            #table2excel tbody td { padding: 3px 4px; }
        }
    </style>

    <div class="content-wrapper">
        <section class="content-header no-report">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Reports</li>
                            <li class="breadcrumb-item">Sale Reports</li>
                            <li class="breadcrumb-item active">Bsp Sale Report</li>
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
                            <form id="form" class="no-report">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="mb-1">From Date</label>
                                            <input type="text" name="df" id="df" class="form-control form-control-sm date" placeholder="From Date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="mb-1">To Date</label>
                                            <input type="text" name="dt" id="dt" class="form-control form-control-sm date" placeholder="To Date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="mb-1">Airline</label>
                                            <select name="airline" class="form-control form-control-sm select2">
                                                <option value="">All Airlines</option>
                                                {!! App\Models\Airline::dropdown() !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="mb-1 d-block">&nbsp;</label>
                                            <button type="button" class="btn btn-flat btn-sm btn-dark" onclick="get_data()">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div id="report-area">
                                <div class="bsp-report-header report-show">
                                    <table width="100%">
                                        <tr>
                                            <td width="20%" style="text-align: left; vertical-align: top;">
                                                <img src="{{ $company->logo_url }}" width="120" alt="Logo" onerror="this.style.display='none'">
                                            </td>
                                            <td width="60%" style="text-align: center; vertical-align: top;">
                                                <div class="company-name">{{ $company->name }}</div>
                                                <div class="company-info">
                                                    {{ $company->address }}<br>
                                                    Phone: {{ $company->phone }}<br>
                                                    Email: {{ $company->email }}<br>
                                                    Govt. Lic No: {{ $company->govt_lic_no }} , IATA No: {{ $company->iata_no }} , NTN: {{ $company->ntn }}
                                                </div>
                                            </td>
                                            <td width="20%" style="vertical-align: bottom;">
                                                <div class="bsp-report-print-date">
                                                    Printing Date: <span id="printing_date"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="bsp-report-title">Bsp Sale Report</div>
                                    <div class="bsp-report-dates">
                                        From: <span id="display_from">-</span> | To: <span id="display_to">-</span>
                                    </div>
                                </div>

                                <table id="table2excel" class="table">
                                    <thead>
                                    <tr>
                                        <th>Air</th>
                                        <th>Doc No</th>
                                        <th>Pass Name</th>
                                        <th>Date</th>
                                        <th class="text-right">Fare</th>
                                        <th class="text-right">Taxes</th>
                                        <th class="text-right">Com</th>
                                        <th class="text-right">WH</th>
                                        <th class="text-right">O.Income</th>
                                        <th class="text-right">Ded</th>
                                        <th class="text-right">Payable</th>
                                    </tr>
                                    </thead>
                                    <tbody id="report_body"></tbody>
                                </table>

                                <div class="report-actions no-report" style="margin-top: 15px;">
                                    <button type="button" class="btn btn-sm btn-excel exportToExcel">
                                        <i class="fa fa-file-excel"></i> Excel
                                    </button>
                                    <button type="button" class="btn btn-sm btn-word exportToWord">
                                        <i class="fa fa-file-word"></i> Word
                                    </button>
                                    <button type="button" class="btn btn-sm btn-email" onclick="emailReport()">
                                        <i class="fa fa-envelope"></i> Email
                                    </button>
                                    <button type="button" id="printDiv" class="btn btn-sm btn-print-report">
                                        <i class="fa fa-print"></i> Print
                                    </button>
                                </div>

                                <div class="report-footer report-show">
                                    <table>
                                        <tr>
                                            <td style="text-align: left;">Copyright &copy; {{ date('Y') }} Tour Vision Travel Pvt Ltd.</td>
                                            <td style="text-align: center;">Website: www.toursvision.com</td>
                                            <td style="text-align: right;">All rights reserved.</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ URL::asset('public/export_excel/jquery.table2excel.js') }}"></script>
    <script>
        var COLUMN_COUNT = 11;

        $(function () {
            $('.select2').select2();
            setDefaultDates();
            updatePrintingDate();
            get_data();
        });

        function setDefaultDates() {
            var today = new Date();
            var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            var isoFmt = function (d) {
                return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);
            };
            if (!$('#df').val()) { $('#df').val(isoFmt(firstDay)); }
            if (!$('#dt').val()) { $('#dt').val(isoFmt(today)); }
            $('#display_from').text(formatDateDisplay($('#df').val()));
            $('#display_to').text(formatDateDisplay($('#dt').val()));
        }

        function updatePrintingDate() {
            var now = new Date();
            var pad = function (n) { return ('0' + n).slice(-2); };
            $('#printing_date').text(
                now.getFullYear() + '-' + pad(now.getMonth() + 1) + '-' + pad(now.getDate()) +
                ' ' + pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds())
            );
        }

        function formatDateDisplay(dateStr) {
            if (!dateStr) return '-';
            var value = String(dateStr).substring(0, 10);
            var parts = value.split('-');
            if (parts.length === 3) {
                return parts[2] + '-' + parts[1] + '-' + parts[0];
            }
            return value;
        }

        // Absolute value formatted with thousands separators and 2 decimals.
        function formatNumber(num) {
            num = Math.abs(parseFloat(num) || 0);
            return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Accounting style: negatives (and forced negatives) shown in parentheses.
        function formatSigned(num, forceNegative) {
            num = parseFloat(num) || 0;
            if (forceNegative || num < 0) {
                return '(' + formatNumber(num) + ')';
            }
            return formatNumber(num);
        }

        function td(value, cls) {
            return '<td' + (cls ? ' class="' + cls + '"' : '') + '>' + value + '</td>';
        }

        function rowHtml(row, isRefund) {
            var html = '<tr>';
            html += td(row.air || '');
            html += td(row.doc_no || '');
            html += td((row.pax_name || ''));
            html += td(formatDateDisplay(row.date), 'text-center');
            // For refunds, Fare and Taxes are reversals -> always shown in parentheses.
            html += td(formatSigned(row.fare, isRefund), 'text-right');
            html += td(formatSigned(row.taxes, isRefund), 'text-right');
            html += td(formatSigned(row.com), 'text-right');
            html += td(formatSigned(row.wh), 'text-right');
            html += td(formatSigned(row.oincome), 'text-right');
            html += td(formatSigned(row.ded), 'text-right');
            html += td(formatSigned(row.payable), 'text-right');
            html += '</tr>';
            return html;
        }

        function totalRowHtml(label, totals, cls, isRefund) {
            var html = '<tr class="' + cls + '">';
            html += '<td colspan="4" class="text-right">' + label + '</td>';
            html += td(formatSigned(totals.fare, isRefund), 'text-right');
            html += td(formatSigned(totals.taxes, isRefund), 'text-right');
            html += td(formatSigned(totals.com), 'text-right');
            html += td(formatSigned(totals.wh), 'text-right');
            html += td(formatSigned(totals.oincome), 'text-right');
            html += td(formatSigned(totals.ded), 'text-right');
            html += td(formatSigned(totals.payable), 'text-right');
            html += '</tr>';
            return html;
        }

        function groupTitleHtml(title) {
            return '<tr class="group-title"><td colspan="' + COLUMN_COUNT + '">' + title + '</td></tr>';
        }

        function get_data() {
            $("#loader").show();
            $('#display_from').text(formatDateDisplay($('#df').val()));
            $('#display_to').text(formatDateDisplay($('#dt').val()));
            updatePrintingDate();

            $.ajax({
                url: "{{ url('reports/sale/get_bsp_sale_report') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                dataType: "JSON",
                data: $("#form").serialize(),
                success: function (data) {
                    var html = '';
                    var i;

                    // ---- Sales section (branch) ----
                    html += groupTitleHtml(data.branch_label || 'Head Office');
                    if (data.sales.length) {
                        for (i = 0; i < data.sales.length; i++) {
                            html += rowHtml(data.sales[i], false);
                        }
                    } else {
                        html += '<tr class="empty-row"><td colspan="' + COLUMN_COUNT + '">No sales found for the selected range.</td></tr>';
                    }
                    html += totalRowHtml('Branch Total:', data.sales_totals, 'branch-total', false);

                    // ---- Refund section ----
                    if (data.refunds.length) {
                        html += groupTitleHtml('Refund');
                        for (i = 0; i < data.refunds.length; i++) {
                            html += rowHtml(data.refunds[i], true);
                        }
                        html += totalRowHtml('Branch Total:', data.refund_totals, 'branch-total', true);
                    }

                    // ---- Net total ----
                    html += totalRowHtml('Net Total:', data.net_totals, 'net-total', false);

                    $("#report_body").html(html);
                    $("#loader").hide();
                },
                error: function () {
                    $("#loader").hide();
                    toastr.error('Failed to load report data.');
                }
            });
        }

        $('#printDiv').on('click', function () {
            window.print();
        });

        function emailReport() {
            var subject = encodeURIComponent('Bsp Sale Report - {{ $company->name }}');
            var body = encodeURIComponent('Please find the Bsp Sale Report.\n\nFrom: ' + $('#display_from').text() + '\nTo: ' + $('#display_to').text());
            window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
        }

        var jq = $.noConflict();
        jq(document).ready(function () {
            jq(".exportToExcel").click(function () {
                jq("#table2excel").table2excel({
                    exclude: ".noExl",
                    name: "Bsp Sale Report",
                    filename: "bsp_sale_report_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true
                });
            });

            jq(".exportToWord").click(function () {
                var header = document.querySelector('.bsp-report-header').outerHTML;
                var table = document.getElementById('table2excel').outerHTML;
                var footer = document.querySelector('.report-footer').outerHTML;
                var html = '<html><head><meta charset="utf-8"></head><body>' + header + table + footer + '</body></html>';
                var blob = new Blob(['\ufeff', html], { type: 'application/msword' });
                var link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'bsp_sale_report_' + new Date().toISOString().slice(0, 10) + '.doc';
                link.click();
            });
        });
    </script>
@endsection
