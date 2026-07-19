@extends('layouts.app')

@php
    $reportTitle = $reportTitle ?? 'Pending Invoice Report';
    $reportSlug = $reportSlug ?? 'pending_invoice_report';
    $dataUrl = $dataUrl ?? url('reports/sale/get_pending_invoice_report');
    $emptyMessage = $emptyMessage ?? 'No pending invoices found for the selected filters.';
@endphp

@section('content')
    <style>
        .invoice-report-header {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-bottom: 15px;
        }
        .invoice-report-header .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .invoice-report-header .company-info {
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .invoice-report-title {
            font-size: 18px;
            font-weight: bold;
            margin: 12px 0 6px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .invoice-report-dates {
            font-size: 13px;
            text-align: center;
            margin-bottom: 10px;
        }
        .invoice-report-print-date {
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
            border: 1px solid #adb5bd;
            padding: 8px 6px;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        #table2excel tbody td {
            border: 1px solid #ced4da;
            padding: 6px;
            vertical-align: middle;
        }
        #table2excel .text-right { text-align: right; }
        #table2excel .client-group td {
            font-weight: bold;
            background-color: #f1f3f5;
            border: 1px solid #adb5bd;
            text-transform: uppercase;
            padding: 7px 6px;
        }
        #table2excel .grand-total td {
            font-weight: bold;
            background-color: #e9ecef;
            border: 1px solid #adb5bd;
            border-top: 2px solid #495057;
        }
        #table2excel .empty-row td {
            text-align: center;
            color: #868e96;
            padding: 16px;
        }
        .report-actions .btn {
            margin-right: 6px;
            margin-bottom: 6px;
        }
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
            @page { size: portrait; margin: 10mm; }
            #table2excel { font-size: 10px; }
            #table2excel thead th,
            #table2excel tbody td { padding: 4px; }
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
                            <li class="breadcrumb-item">Invoice Reports</li>
                            <li class="breadcrumb-item active">{{ $reportTitle }}</li>
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
                                            <select name="ledger" class="form-control form-control-sm select2">
                                                <option value="">All Clients</option>
                                                {!! App\Models\Accounts\TransactionAccount::dropdown() !!}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="type" class="form-control form-control-sm select2">
                                                <option value="">All Invoice Types</option>
                                                <option value="1">Ticket</option>
                                                <option value="2">Hotel</option>
                                                <option value="3">Visa</option>
                                                <option value="4">Transport</option>
                                                <option value="5">Tour</option>
                                                <option value="6">Other</option>
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
                                <div class="invoice-report-print-date report-show">
                                    Printing Date: <span id="printing_date"></span>
                                </div>

                                <div class="invoice-report-header report-show">
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
                                    <div class="invoice-report-title">{{ $reportTitle }}</div>
                                    <div class="invoice-report-dates">
                                        From: <span id="display_from">-</span> &nbsp;|&nbsp; To: <span id="display_to">-</span>
                                    </div>
                                </div>

                                <table id="table2excel" class="table">
                                    <thead>
                                    <tr>
                                        <th>Invoice No.</th>
                                        <th>Invoice Date</th>
                                        <th>Passenger Name</th>
                                        <th class="text-right">Bill Amount</th>
                                        <th class="text-right">Paid Amount</th>
                                        <th class="text-right">Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody id="get_data"></tbody>
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
            var fmt = function (d) {
                return ('0' + d.getDate()).slice(-2) + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear();
            };
            var isoFmt = function (d) {
                return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);
            };
            if (!$('#df').val()) {
                $('#df').val(isoFmt(firstDay));
            }
            if (!$('#dt').val()) {
                $('#dt').val(isoFmt(today));
            }
            $('#display_from').text(fmt(firstDay));
            $('#display_to').text(fmt(today));
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
            var parts = String(dateStr).substring(0, 10).split('-');
            if (parts.length === 3) {
                return parts[2] + '-' + parts[1] + '-' + parts[0];
            }
            return dateStr;
        }

        function formatNumber(num) {
            num = parseFloat(num) || 0;
            return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function get_data() {
            $("#loader").show();
            var df = $('input[name="df"]').val();
            var dt = $('input[name="dt"]').val();
            $('#display_from').text(formatDateDisplay(df));
            $('#display_to').text(formatDateDisplay(dt));
            updatePrintingDate();

            $.ajax({
                url: "{{ $dataUrl }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                dataType: "JSON",
                data: $("#form").serialize(),
                success: function (data) {
                    var htmlData = '';
                    if (!data.groups || !data.groups.length) {
                        htmlData = '<tr class="empty-row"><td colspan="6">{{ $emptyMessage }}</td></tr>';
                    } else {
                        for (var g = 0; g < data.groups.length; g++) {
                            var group = data.groups[g];
                            htmlData += '<tr class="client-group"><td colspan="6">' + (group.client_name || '') + '</td></tr>';
                            for (var i = 0; i < group.rows.length; i++) {
                                var row = group.rows[i];
                                htmlData += '<tr>';
                                htmlData += '<td>' + row.invoice_no + '</td>';
                                htmlData += '<td>' + formatDateDisplay(row.inv_date) + '</td>';
                                htmlData += '<td>' + (row.passenger_name || '').toUpperCase() + '</td>';
                                htmlData += '<td class="text-right">' + formatNumber(row.bill_amount) + '</td>';
                                htmlData += '<td class="text-right">' + formatNumber(row.paid_amount) + '</td>';
                                htmlData += '<td class="text-right">' + formatNumber(row.balance) + '</td>';
                                htmlData += '</tr>';
                            }
                        }

                        var t = data.grand_totals || {};
                        htmlData += '<tr class="grand-total">';
                        htmlData += '<td colspan="3">Grand Total (' + (t.count || 0) + ')</td>';
                        htmlData += '<td class="text-right">' + formatNumber(t.bill_amount) + '</td>';
                        htmlData += '<td class="text-right">' + formatNumber(t.paid_amount) + '</td>';
                        htmlData += '<td class="text-right">' + formatNumber(t.balance) + '</td>';
                        htmlData += '</tr>';
                    }

                    $("#get_data").html(htmlData);
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
            var subject = encodeURIComponent('{{ $reportTitle }} - {{ $company->name }}');
            var body = encodeURIComponent('Please find the {{ $reportTitle }} attached.\n\nFrom: ' + $('#display_from').text() + '\nTo: ' + $('#display_to').text());
            window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
        }

        var jq = $.noConflict();
        jq(document).ready(function () {
            jq(".exportToExcel").click(function () {
                jq("#table2excel").table2excel({
                    exclude: ".noExl",
                    name: "{{ $reportTitle }}",
                    filename: "{{ $reportSlug }}_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true
                });
            });

            jq(".exportToWord").click(function () {
                var header = document.querySelector('.invoice-report-header').outerHTML;
                var table = document.getElementById('table2excel').outerHTML;
                var footer = document.querySelector('.report-footer').outerHTML;
                var html = '<html><head><meta charset="utf-8"></head><body>' + header + table + footer + '</body></html>';
                var blob = new Blob(['\ufeff', html], { type: 'application/msword' });
                var link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = '{{ $reportSlug }}_' + new Date().toISOString().slice(0, 10) + '.doc';
                link.click();
            });
        });
    </script>
@endsection
