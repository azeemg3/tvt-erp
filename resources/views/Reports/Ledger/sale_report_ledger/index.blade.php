@extends('layouts.app')

@section('content')
    <style>
        .ledger-report-header {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-bottom: 12px;
        }
        .ledger-report-header .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .ledger-report-header .company-info {
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        .ledger-report-subtitle {
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0 2px;
            text-align: center;
        }
        .ledger-report-title {
            font-size: 16px;
            font-weight: bold;
            margin: 4px 0;
            text-align: center;
        }
        .ledger-report-dates {
            font-size: 12px;
            text-align: center;
            margin-bottom: 8px;
        }
        .ledger-report-print-date {
            font-size: 11px;
            text-align: right;
            color: #555;
            margin-bottom: 8px;
        }
        .ledger-section-title {
            font-size: 13px;
            font-weight: bold;
            margin: 16px 0 6px;
            text-align: center;
            text-transform: capitalize;
        }
        .ledger-report-table {
            font-size: 11px;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 8px;
        }
        .ledger-report-table thead th {
            background-color: #f1f3f5;
            border: 1px solid #adb5bd;
            padding: 5px 4px;
            font-size: 10px;
            font-weight: 600;
            white-space: nowrap;
        }
        .ledger-report-table tbody td {
            border: 1px solid #ced4da;
            padding: 4px;
            vertical-align: top;
        }
        .ledger-report-table .text-right { text-align: right; }
        .ledger-report-table .section-total td {
            font-weight: bold;
            background-color: #e9ecef;
            border-top: 1px solid #495057;
        }
        .balance-summary-table {
            max-width: 420px;
            margin: 24px auto 0;
        }
        .balance-summary-table td:last-child {
            text-align: right;
            white-space: nowrap;
        }
        .balance-summary-table .summary-group td {
            font-weight: bold;
            padding-top: 10px;
        }
        .balance-summary-table .summary-total td {
            font-weight: bold;
            border-top: 2px solid #212529;
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
            @page { size: portrait; margin: 10mm; }
            .ledger-report-table { font-size: 9px; }
            .page-break { page-break-before: always; }
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
                            <li class="breadcrumb-item">Ledger Report</li>
                            <li class="breadcrumb-item active">Sale Report Ledger</li>
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
                                        <input type="text" name="df" id="df" class="form-control form-control-sm date" placeholder="From Date">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="dt" id="dt" class="form-control form-control-sm date" placeholder="To Date">
                                    </div>
                                    <div class="col-md-4">
                                        <select name="ledger_id" id="ledger_id" class="form-control form-control-sm select2" required>
                                            <option value="">Select Ledger / Client</option>
                                            {!! App\Models\Accounts\TransactionAccount::dropdown() !!}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="btn_report_search" class="btn btn-flat btn-xs btn-dark">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div id="report-area">
                                <div class="ledger-report-print-date report-show">
                                    Printing Date: <span id="printing_date"></span>
                                </div>

                                <div class="ledger-report-header report-show">
                                    <table width="100%" style="margin-bottom: 8px;">
                                        <tr>
                                            <td width="20%" style="text-align: left; vertical-align: top;">
                                                <img src="{{ $company->logo_url }}" width="120" alt="Logo" onerror="this.style.display='none'">
                                            </td>
                                            <td width="60%" style="text-align: center; vertical-align: top;">
                                                <div class="company-name">{{ $company->name }}</div>
                                                <div class="company-info">
                                                    {{ $company->address }}<br>
                                                    Phone: {{ $company->phone }} &nbsp; Email: {{ $company->email }}<br>
                                                    Govt. Lic No: {{ $company->govt_lic_no }} , IATA No: {{ $company->iata_no }} , NTN: {{ $company->ntn }}
                                                </div>
                                            </td>
                                            <td width="20%"></td>
                                        </tr>
                                    </table>
                                    <div class="ledger-report-subtitle">Statement of: <span id="statement_ledger">-</span></div>
                                    <div class="ledger-report-title">Sale Report Ledger</div>
                                    <div class="ledger-report-dates">
                                        From: <span id="display_from">-</span> &nbsp;|&nbsp; To: <span id="display_to">-</span>
                                    </div>
                                </div>

                                <div id="report-sections" class="report-show"></div>

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
@endsection

@push('scripts')
    <script src="{{ URL::asset('public/export_excel/jquery.table2excel.js') }}"></script>
    <script>
        bootstrapReportFilters('#form', function () {
            setReportDefaultDates('#df', '#dt', '#display_from', '#display_to');
            updatePrintingDate();
            $('#btn_report_search').on('click', get_data);
            $('#printDiv').on('click', function () { window.print(); });
        });

        function setDefaultDates() {
            setReportDefaultDates('#df', '#dt', '#display_from', '#display_to');
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
            if (!dateStr) return '';
            var parts = String(dateStr).substring(0, 10).split('-');
            if (parts.length === 3) {
                if (parts[0].length === 4) {
                    return parts[2] + '-' + parts[1] + '-' + parts[0];
                }
                return parts[0] + '-' + parts[1] + '-' + parts[2];
            }
            return dateStr;
        }

        function formatNumber(num) {
            num = parseFloat(num) || 0;
            return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function buildTicketSection(rows, totals) {
            var html = '<div class="ledger-section-title">Ticket Invoice</div>';
            html += '<table class="ledger-report-table" id="ticket-table"><thead><tr>';
            html += '<th>Voucher Date</th><th>Departure</th><th>Arrival</th><th>V.ID</th><th>Ticket</th>';
            html += '<th>Passenger Name</th><th>Sector</th><th class="text-right">Debit</th><th class="text-right">Credit</th>';
            html += '</tr></thead><tbody>';
            if (!rows.length) {
                html += '<tr><td colspan="9" class="text-center">No ticket invoices in this period.</td></tr>';
            } else {
                for (var i = 0; i < rows.length; i++) {
                    var r = rows[i];
                    html += '<tr>';
                    html += '<td>' + formatDateDisplay(r.voucher_date) + '</td>';
                    html += '<td>' + formatDateDisplay(r.departure) + '</td>';
                    html += '<td>' + formatDateDisplay(r.arrival) + '</td>';
                    html += '<td>' + r.v_id + '</td>';
                    html += '<td>' + (r.ticket || '') + '</td>';
                    html += '<td>' + (r.passenger_name || '') + '</td>';
                    html += '<td>' + (r.sector || '') + '</td>';
                    html += '<td class="text-right">' + formatNumber(r.debit) + '</td>';
                    html += '<td class="text-right">' + formatNumber(r.credit) + '</td>';
                    html += '</tr>';
                }
            }
            html += '<tr class="section-total"><td colspan="7" class="text-right">' + (totals.count || 0) + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.debit) + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.credit) + '</td></tr>';
            html += '</tbody></table>';
            return html;
        }

        function buildVisaSection(rows, totals) {
            var html = '<div class="ledger-section-title">Visa Invoices</div>';
            html += '<table class="ledger-report-table" id="visa-table"><thead><tr>';
            html += '<th>Voucher Date</th><th>Visa Date</th><th>V.ID</th><th>Visa No.</th>';
            html += '<th>Application Name</th><th>Country</th><th class="text-right">Debit</th><th class="text-right">Credit</th>';
            html += '</tr></thead><tbody>';
            if (!rows.length) {
                html += '<tr><td colspan="8" class="text-center">No visa invoices in this period.</td></tr>';
            } else {
                for (var i = 0; i < rows.length; i++) {
                    var r = rows[i];
                    html += '<tr>';
                    html += '<td>' + formatDateDisplay(r.voucher_date) + '</td>';
                    html += '<td>' + formatDateDisplay(r.visa_date) + '</td>';
                    html += '<td>' + r.v_id + '</td>';
                    html += '<td>' + (r.visa_no || '') + '</td>';
                    html += '<td>' + (r.application_name || '') + '</td>';
                    html += '<td>' + (r.country || '') + '</td>';
                    html += '<td class="text-right">' + formatNumber(r.debit) + '</td>';
                    html += '<td class="text-right">' + formatNumber(r.credit) + '</td>';
                    html += '</tr>';
                }
            }
            html += '<tr class="section-total"><td colspan="6" class="text-right">' + (totals.count || 0) + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.debit) + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.credit) + '</td></tr>';
            html += '</tbody></table>';
            return html;
        }

        function buildReceiptSection(rows, totals) {
            var html = '<div class="ledger-section-title">Receipts</div>';
            html += '<table class="ledger-report-table" id="receipt-table"><thead><tr>';
            html += '<th>Voucher Date</th><th>Voucher No.</th><th>Narration</th><th class="text-right">Debit</th><th class="text-right">Credit</th>';
            html += '</tr></thead><tbody>';
            if (!rows.length) {
                html += '<tr><td colspan="5" class="text-center">No receipts in this period.</td></tr>';
            } else {
                for (var i = 0; i < rows.length; i++) {
                    var r = rows[i];
                    html += '<tr>';
                    html += '<td>' + formatDateDisplay(r.voucher_date) + '</td>';
                    html += '<td>' + r.voucher_no + '</td>';
                    html += '<td>' + (r.narration || '') + '</td>';
                    html += '<td class="text-right">' + formatNumber(r.debit) + '</td>';
                    html += '<td class="text-right">' + formatNumber(r.credit) + '</td>';
                    html += '</tr>';
                }
            }
            html += '<tr class="section-total"><td colspan="3" class="text-right">' + (totals.count || 0) + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.debit) + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.credit) + '</td></tr>';
            html += '</tbody></table>';
            return html;
        }

        function buildBalanceSummary(summary) {
            var html = '<div class="page-break"></div>';
            html += '<div class="ledger-section-title">Balance Summary</div>';
            html += '<table class="ledger-report-table balance-summary-table" id="summary-table"><tbody>';
            html += '<tr><td>Balance B/F</td><td>' + (summary.balance_bf_label || '') + '</td></tr>';
            html += '<tr class="summary-group"><td colspan="2">Invoices</td></tr>';
            html += '<tr><td style="padding-left:16px;">Ticket Invoices</td><td>' + formatNumber(summary.ticket_invoices) + ' Dr</td></tr>';
            html += '<tr><td style="padding-left:16px;">Visa Invoices</td><td>' + formatNumber(summary.visa_invoices) + ' Dr</td></tr>';
            html += '<tr><td style="padding-left:16px;"></td><td><strong>' + formatNumber(summary.invoices_total) + ' Dr</strong></td></tr>';
            html += '<tr class="summary-group"><td colspan="2">Vouchers</td></tr>';
            html += '<tr><td style="padding-left:16px;">Receipts</td><td>(' + formatNumber(summary.receipts_total) + ') Cr</td></tr>';
            html += '<tr><td style="padding-left:16px;"></td><td><strong>(' + formatNumber(summary.receipts_total) + ') Cr</strong></td></tr>';
            html += '<tr class="summary-total"><td>Closing Balance</td><td>' + (summary.closing_balance_label || '') + '</td></tr>';
            html += '</tbody></table>';
            return html;
        }

        function get_data() {
            var ledgerId = $('#ledger_id').val() || $('select[name="ledger_id"]').val();
            if (!ledgerId) {
                toastr.warning('Please select a ledger account.');
                return;
            }

            $("#loader").show();
            var df = $('input[name="df"]').val();
            var dt = $('input[name="dt"]').val();
            $('#display_from').text(formatDateDisplay(df));
            $('#display_to').text(formatDateDisplay(dt));
            updatePrintingDate();

            $.ajax({
                url: "{{ url('reports/ledger_reports/get_sale_rep_ledger') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                dataType: "JSON",
                data: {
                    df: df,
                    dt: dt,
                    ledger_id: ledgerId
                },
                success: function (data) {
                    $('#statement_ledger').text(data.ledger_name || '-');
                    var html = '';
                    html += buildTicketSection(data.ticket_invoices || [], data.ticket_totals || {});
                    html += buildVisaSection(data.visa_invoices || [], data.visa_totals || {});
                    html += buildReceiptSection(data.receipts || [], data.receipt_totals || {});
                    html += buildBalanceSummary(data.summary || {});
                    $('#report-sections').html(html);
                    $("#loader").hide();
                },
                error: function (xhr) {
                    $("#loader").hide();
                    var msg = 'Failed to load report data.';
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        } else if (xhr.responseJSON.errors) {
                            msg = Object.values(xhr.responseJSON.errors).flat().join(' ');
                        }
                    }
                    toastr.error(msg);
                }
            });
        }

        window.get_data = get_data;

        function emailReport() {
            var subject = encodeURIComponent('Sale Report Ledger - {{ $company->name }}');
            var body = encodeURIComponent('Sale Report Ledger\n\nLedger: ' + $('#statement_ledger').text() + '\nFrom: ' + $('#display_from').text() + '\nTo: ' + $('#display_to').text());
            window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
        }

        $(document).on('click', '.exportToExcel', function () {
            $("#report-area").table2excel({
                exclude: ".noExl",
                name: "Sale Report Ledger",
                filename: "sale_report_ledger_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                fileext: ".xls"
            });
        });

        $(document).on('click', '.exportToWord', function () {
            var header = document.querySelector('.ledger-report-header').outerHTML;
            var sections = document.getElementById('report-sections').innerHTML;
            var footer = document.querySelector('.report-footer').outerHTML;
            var html = '<html><head><meta charset="utf-8"></head><body>' + header + sections + footer + '</body></html>';
            var blob = new Blob(['\ufeff', html], { type: 'application/msword' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'sale_report_ledger_' + new Date().toISOString().slice(0, 10) + '.doc';
            link.click();
        });
    </script>
@endpush
