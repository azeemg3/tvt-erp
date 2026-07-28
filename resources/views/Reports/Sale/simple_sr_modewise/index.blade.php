@extends('layouts.app')

@section('content')
    <style>
        .sale-report-header {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-bottom: 15px;
        }
        .sale-report-header .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .sale-report-header .company-info {
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .sale-report-title {
            font-size: 18px;
            font-weight: bold;
            margin: 12px 0 6px;
            text-align: center;
            text-transform: uppercase;
        }
        .sale-report-dates {
            font-size: 13px;
            text-align: center;
            margin-bottom: 10px;
        }
        .sale-report-print-date {
            font-size: 11px;
            text-align: right;
            color: #555;
            margin-bottom: 8px;
        }
        #table2excel {
            font-size: 12px;
            border-collapse: collapse;
            width: 100%;
        }
        #table2excel thead th {
            background-color: #e9ecef;
            border: 1px solid #dee2e6;
            padding: 8px 6px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        #table2excel tbody td {
            border: 1px solid #dee2e6;
            padding: 6px;
            vertical-align: middle;
        }
        #table2excel .text-right { text-align: right; }
        #table2excel .text-center { text-align: center; }
        #table2excel .group-title td {
            font-weight: bold;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px 10px;
            font-size: 13px;
        }
        #table2excel .section-total td {
            font-weight: bold;
            background-color: #f1f3f5;
            border: 1px solid #dee2e6;
        }
        #table2excel .grand-total td {
            font-weight: bold;
            background-color: #e9ecef;
            border-top: 2px solid #495057;
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
            @page { size: landscape; margin: 10mm; }
            #table2excel { font-size: 10px; }
            #table2excel thead th, #table2excel tbody td { padding: 4px; }
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
                            <li class="breadcrumb-item active">Simple Sale Register Modewise</li>
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
                                            <input type="text" name="df" id="df" class="form-control form-control-sm date" placeholder="From Date">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="dt" id="dt" class="form-control form-control-sm date" placeholder="To Date">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="mode" class="form-control form-control-sm select2">
                                                <option value="">All Modes</option>
                                                <option value="ticket">Ticket</option>
                                                <option value="hotel">Hotel</option>
                                                <option value="visa">Visa</option>
                                                <option value="transfer">Transfer</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-flat btn-xs btn-dark" onclick="get_data()">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div id="report-area">
                                <div class="sale-report-print-date report-show">
                                    Printing Date: <span id="printing_date"></span>
                                </div>

                                <div class="sale-report-header report-show">
                                    <table width="100%" style="margin-bottom: 10px;">
                                        <tr>
                                            <td width="20%" style="text-align: left; vertical-align: top;">
                                                <img src="{{ $company->logo_url }}" width="120" alt="Logo" onerror="this.style.display='none'">
                                            </td>
                                            <td width="60%" style="text-align: center; vertical-align: top;">
                                                <div class="company-name">{{ $company->name }} (Head Office)</div>
                                                <div class="company-info">
                                                    {{ $company->address }}<br>
                                                    Phone: {{ $company->phone }} &nbsp;|&nbsp; Email: {{ $company->email }}<br>
                                                    Govt. Lic No: {{ $company->govt_lic_no }} &nbsp;|&nbsp; IATA No: {{ $company->iata_no }} &nbsp;|&nbsp; NTN: {{ $company->ntn }}
                                                </div>
                                            </td>
                                            <td width="20%"></td>
                                        </tr>
                                    </table>
                                    <div class="sale-report-title">Mode Wise Sale Summary</div>
                                    <div class="sale-report-dates">
                                        From: <span id="display_from">-</span> &nbsp;|&nbsp; To: <span id="display_to">-</span>
                                    </div>
                                </div>

                                <table id="table2excel" class="table">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Inv Date</th>
                                        <th class="text-center">Inv Id</th>
                                        <th>Client</th>
                                        <th>Vendor</th>
                                        <th>Description</th>
                                        <th class="text-right">Profit</th>
                                        <th class="text-right">Receivable</th>
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

        function formatNumber(num) {
            num = parseFloat(num) || 0;
            return num.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
        }

        function rowHtml(row) {
            var html = '<tr>';
            html += '<td class="text-center">' + formatDateDisplay(row.inv_date) + '</td>';
            html += '<td class="text-center">' + row.invoice_id + '</td>';
            html += '<td>' + (row.client_name || '') + '</td>';
            html += '<td>' + (row.vendor_name || '') + '</td>';
            html += '<td>' + (row.description || '') + '</td>';
            html += '<td class="text-right">' + formatNumber(row.profit) + '</td>';
            html += '<td class="text-right">' + formatNumber(row.receiveable) + '</td>';
            html += '</tr>';
            return html;
        }

        function sectionTotalHtml(totals) {
            var html = '<tr class="section-total">';
            html += '<td colspan="5"></td>';
            html += '<td class="text-right">' + formatNumber(totals.profit) + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.receiveable) + '</td>';
            html += '</tr>';
            return html;
        }

        function get_data() {
            $("#loader").show();
            var df = $('input[name="df"]').val();
            var dt = $('input[name="dt"]').val();
            $('#display_from').text(formatDateDisplay(df));
            $('#display_to').text(formatDateDisplay(dt));
            updatePrintingDate();

            $.ajax({
                url: "{{ url('reports/sale/get_simple_sr_modewise') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                dataType: "JSON",
                data: $("#form").serialize(),
                success: function (data) {
                    var html = '';
                    var hasRows = false;

                    for (var s in data.sections) {
                        var section = data.sections[s];
                        html += '<tr class="group-title"><td colspan="7">' + section.label + '</td></tr>';

                        if (section.rows.length === 0) {
                            html += '<tr class="empty-row"><td colspan="7">No records found.</td></tr>';
                        } else {
                            hasRows = true;
                            for (var i in section.rows) {
                                html += rowHtml(section.rows[i]);
                            }
                        }

                        html += sectionTotalHtml(section.totals);
                    }

                    if (data.grand_total) {
                        html += '<tr class="grand-total">';
                        html += '<td colspan="5"></td>';
                        html += '<td class="text-right">' + formatNumber(data.grand_total.profit) + '</td>';
                        html += '<td class="text-right">' + formatNumber(data.grand_total.receiveable) + '</td>';
                        html += '</tr>';
                    }

                    if (!hasRows && data.sections.length === 0) {
                        html = '<tr class="empty-row"><td colspan="7">No records found for the selected criteria.</td></tr>';
                    }

                    $('#report_body').html(html);
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
            var subject = encodeURIComponent('Simple Sale Register Modewise - {{ $company->name }}');
            var body = encodeURIComponent('Please find the Mode Wise Sale Summary report.\n\nFrom: ' + $('#display_from').text() + '\nTo: ' + $('#display_to').text());
            window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
        }

        var jq = $.noConflict();
        jq(document).ready(function () {
            jq(".exportToExcel").click(function () {
                jq("#table2excel").table2excel({
                    exclude: ".noExl",
                    name: "Simple Sale Register Modewise",
                    filename: "simple_sr_modewise_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true
                });
            });

            jq(".exportToWord").click(function () {
                var header = document.querySelector('.sale-report-header').outerHTML;
                var table = document.getElementById('table2excel').outerHTML;
                var footer = document.querySelector('.report-footer').outerHTML;
                var html = '<html><head><meta charset="utf-8"></head><body>' + header + table + footer + '</body></html>';
                var blob = new Blob(['\ufeff', html], { type: 'application/msword' });
                var link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'simple_sr_modewise_' + new Date().toISOString().slice(0, 10) + '.doc';
                link.click();
            });
        });
    </script>
@endsection
