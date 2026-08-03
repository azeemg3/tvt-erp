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
        .ledger-format-table {
            font-size: 11px;
            border-collapse: collapse;
            width: 100%;
        }
        .ledger-format-table thead th {
            background-color: #f1f3f5;
            border: 1px solid #adb5bd;
            padding: 5px 4px;
            font-size: 10px;
            font-weight: 600;
        }
        .ledger-format-table tbody td {
            border: 1px solid #ced4da;
            padding: 4px;
            vertical-align: top;
        }
        .ledger-format-table .text-right { text-align: right; }
        .ledger-format-table .section-head td {
            font-weight: bold;
            background-color: #f8f9fa;
            border: 1px solid #adb5bd;
            padding: 6px 4px;
        }
        .ledger-format-table .section-total td {
            font-weight: bold;
            background-color: #e9ecef;
            border-top: 1px solid #495057;
        }
        .ledger-format-table .period-total td {
            font-weight: bold;
            background-color: #dee2e6;
            border-top: 2px solid #212529;
        }
        .ledger-format-table .kind-icon {
            width: 18px;
            text-align: center;
            color: #495057;
        }
        .balance-summary-table {
            max-width: 480px;
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
        @media print {
            .no-report { display: none !important; }
            .report-show { display: block !important; }
            .main-footer, .main-header, .main-sidebar { display: none !important; }
            .page-break { page-break-before: always; }
        }
    </style>

    <div class="content-wrapper">
        <section class="content-header no-report">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item">Ledger Report</li>
                    <li class="breadcrumb-item active">Ledger Report Format 1</li>
                </ol>
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
                                        <select name="ledger_id" class="form-control form-control-sm select2" required>
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
                                                <div class="company-name">{{ $company->name }} (Head Office)</div>
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
                                    <div class="ledger-report-title">Ledger Report Format 1</div>
                                    <div class="ledger-report-dates">
                                        From: <span id="display_from">-</span> &nbsp;|&nbsp; To: <span id="display_to">-</span>
                                    </div>
                                </div>

                                <div class="report-show" style="overflow-x: auto;">
                                    <table class="ledger-format-table" id="main-ledger-table">
                                        <thead>
                                        <tr>
                                            <th style="width: 24px;"></th>
                                            <th>Voucher Date</th>
                                            <th>V.Id</th>
                                            <th>Ticket/Chq/Ref</th>
                                            <th>Passenger</th>
                                            <th>Sector</th>
                                            <th class="text-right">Debit</th>
                                            <th class="text-right">Credit</th>
                                        </tr>
                                        </thead>
                                        <tbody id="ledger_body"></tbody>
                                    </table>
                                </div>

                                <div id="balance_summary_wrap" class="report-show page-break"></div>

                                <div class="report-actions no-report" style="margin-top: 15px;">
                                    <button type="button" class="btn btn-sm btn-excel exportToExcel"><i class="fa fa-file-excel"></i> Excel</button>
                                    <button type="button" class="btn btn-sm btn-word exportToWord"><i class="fa fa-file-word"></i> Word</button>
                                    <button type="button" class="btn btn-sm btn-email" onclick="emailReport()"><i class="fa fa-envelope"></i> Email</button>
                                    <button type="button" id="printDiv" class="btn btn-sm btn-print-report"><i class="fa fa-print"></i> Print</button>
                                </div>

                                <div class="report-footer report-show">
                                    <table width="100%">
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

        function kindIcon(kind) {
            if (kind === 'ticket') return '<i class="fas fa-plane"></i>';
            if (kind === 'visa') return '<i class="fas fa-user"></i>';
            if (kind === 'hotel') return '<i class="fas fa-hotel"></i>';
            if (kind === 'transfer') return '<i class="fas fa-bus"></i>';
            return '<i class="fas fa-file"></i>';
        }

        function amountDrLabel(amount) {
            amount = parseFloat(amount) || 0;
            if (amount === 0) return 'Nil';
            return formatNumber(amount) + ' Dr';
        }

        function amountCrLabel(amount) {
            amount = parseFloat(amount) || 0;
            if (amount === 0) return 'Nil';
            return '(' + formatNumber(amount) + ') Cr';
        }

        function rowHtml(icon, row) {
            var ref = row.ticket_chq_ref || '';
            var html = '<tr>';
            html += '<td class="kind-icon">' + icon + '</td>';
            html += '<td>' + formatDateDisplay(row.voucher_date) + '</td>';
            html += '<td>' + (row.v_id || '') + '</td>';
            html += '<td>' + ref + '</td>';
            html += '<td>' + (row.passenger || '') + '</td>';
            html += '<td>' + (row.sector || '') + '</td>';
            html += '<td class="text-right">' + (row.debit > 0 ? formatNumber(row.debit) : '0.00') + '</td>';
            html += '<td class="text-right">' + (row.credit > 0 ? formatNumber(row.credit) : '0.00') + '</td>';
            html += '</tr>';
            return html;
        }

        function sectionTotalRow(colspanLabel, debit, credit, extraClass) {
            var html = '<tr class="section-total ' + (extraClass || '') + '">';
            html += '<td colspan="6" class="text-right">' + colspanLabel + '</td>';
            html += '<td class="text-right">' + (debit > 0 ? formatNumber(debit) : formatNumber(debit)) + '</td>';
            html += '<td class="text-right">' + (credit > 0 ? formatNumber(credit) : formatNumber(credit)) + '</td>';
            html += '</tr>';
            return html;
        }

        function buildBalanceSummary(summary) {
            var s = summary || {};
            var html = '<div class="ledger-report-title" style="margin-top: 20px;">Balance Summary</div>';
            html += '<table class="ledger-format-table balance-summary-table"><tbody>';
            html += '<tr><td>Opening Balance</td><td>' + (s.opening_balance_label || '') + '</td></tr>';
            html += '<tr class="summary-group"><td colspan="2">Invoices</td></tr>';
            html += '<tr><td style="padding-left:16px;">Ticket Invoices</td><td>' + amountDrLabel(s.ticket_invoices) + '</td></tr>';
            html += '<tr><td style="padding-left:16px;">Hotel Invoices</td><td>' + amountDrLabel(s.hotel_invoices) + '</td></tr>';
            html += '<tr><td style="padding-left:16px;">Visa Invoices</td><td>' + amountDrLabel(s.visa_invoices) + '</td></tr>';
            html += '<tr><td style="padding-left:16px;">Transfer Invoices</td><td>' + amountDrLabel(s.transfer_invoices) + '</td></tr>';
            html += '<tr><td style="padding-left:16px;">Other Invoices</td><td>' + amountDrLabel(s.other_invoices) + '</td></tr>';
            html += '<tr><td></td><td><strong>' + (s.invoices_total_label || amountDrLabel(s.invoices_total)) + '</strong></td></tr>';
            html += '<tr class="summary-group"><td colspan="2">Refunds</td></tr>';
            html += '<tr><td style="padding-left:16px;">Ticket Refunds</td><td>' + amountCrLabel(s.ticket_refunds) + '</td></tr>';
            html += '<tr><td style="padding-left:16px;">Hotel Refunds</td><td>' + amountCrLabel(s.hotel_refunds) + '</td></tr>';
            html += '<tr><td style="padding-left:16px;">Visa Refunds</td><td>' + amountCrLabel(s.visa_refunds) + '</td></tr>';
            html += '<tr><td style="padding-left:16px;">Transfer Refunds</td><td>' + amountCrLabel(s.transfer_refunds) + '</td></tr>';
            html += '<tr><td style="padding-left:16px;">Other Refunds</td><td>' + amountCrLabel(s.other_refunds) + '</td></tr>';
            html += '<tr><td></td><td><strong>' + (s.refunds_total_label || amountCrLabel(s.refunds_total)) + '</strong></td></tr>';
            html += '<tr class="summary-group"><td colspan="2">Vouchers</td></tr>';
            html += '<tr><td style="padding-left:16px;">Receipts</td><td>' + amountCrLabel(s.receipts_total) + '</td></tr>';
            html += '<tr><td style="padding-left:16px;">Payments</td><td>' + amountCrLabel(s.payments_total) + '</td></tr>';
            html += '<tr><td></td><td><strong>' + (s.vouchers_total_label || amountCrLabel(s.vouchers_total)) + '</strong></td></tr>';
            html += '<tr class="summary-total"><td>Closing Balance</td><td>' + (s.closing_balance_label || '') + '</td></tr>';
            html += '</tbody></table>';
            return html;
        }

        function get_data() {
            var ledgerId = $('select[name="ledger_id"]').val();
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
                url: "{{ url('reports/ledger_reports/get_ledger_rep_first_format') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                dataType: "JSON",
                data: { df: df, dt: dt, ledger_id: ledgerId },
                success: function (data) {
                    $('#statement_ledger').text(data.ledger_name || '-');
                    var html = '';

                    html += '<tr class="section-head"><td colspan="8">Invoices</td></tr>';
                    if (!data.invoices || !data.invoices.length) {
                        html += '<tr><td colspan="8" class="text-center">No invoices in this period.</td></tr>';
                    } else {
                        for (var i = 0; i < data.invoices.length; i++) {
                            var inv = data.invoices[i];
                            html += rowHtml(kindIcon(inv.kind), inv);
                        }
                    }
                    html += sectionTotalRow('', data.invoice_section_total || 0, 0);

                    html += '<tr class="section-head"><td colspan="8">Refunds</td></tr>';
                    if (data.refunds && data.refunds.length) {
                        for (var r = 0; r < data.refunds.length; r++) {
                            html += rowHtml(kindIcon(data.refunds[r].kind), data.refunds[r]);
                        }
                    }
                    html += sectionTotalRow('', 0, data.refund_section_total || 0);

                    html += '<tr class="section-head"><td colspan="8">Cash &amp; Bank Receipt</td></tr>';
                    if (data.receipts && data.receipts.length) {
                        for (var rc = 0; rc < data.receipts.length; rc++) {
                            html += rowHtml('', data.receipts[rc]);
                        }
                    }
                    html += sectionTotalRow('', 0, data.receipt_section_total || 0);

                    html += '<tr class="section-head"><td colspan="8">Cash Payments</td></tr>';
                    if (data.payments && data.payments.length) {
                        for (var p = 0; p < data.payments.length; p++) {
                            html += rowHtml('', data.payments[p]);
                        }
                    }
                    html += sectionTotalRow('', 0, data.payment_section_total || 0);

                    html += '<tr class="period-total">';
                    html += '<td colspan="6"></td>';
                    html += '<td class="text-right">' + formatNumber(data.period_total_debit || 0) + '</td>';
                    html += '<td class="text-right">' + formatNumber(data.period_total_credit || 0) + '</td>';
                    html += '</tr>';

                    $('#ledger_body').html(html);
                    $('#balance_summary_wrap').html(buildBalanceSummary(data.summary));
                    $("#loader").hide();
                },
                error: function (xhr) {
                    $("#loader").hide();
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to load report data.';
                    toastr.error(msg);
                }
            });
        }
        window.get_data = get_data;

        function emailReport() {
            var subject = encodeURIComponent('Ledger Report Format 1 - {{ $company->name }}');
            var body = encodeURIComponent('Ledger: ' + $('#statement_ledger').text() + '\nFrom: ' + $('#display_from').text() + '\nTo: ' + $('#display_to').text());
            window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
        }

        $(document).on('click', '.exportToExcel', function () {
            $("#report-area").table2excel({
                name: "Ledger Report Format 1",
                filename: "ledger_report_format_1_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls"
            });
        });
        $(document).on('click', '.exportToWord', function () {
            var header = document.querySelector('.ledger-report-header').outerHTML;
            var table = document.getElementById('main-ledger-table').outerHTML;
            var summary = document.getElementById('balance_summary_wrap').innerHTML;
            var html = '<html><head><meta charset="utf-8"></head><body>' + header + table + summary + '</body></html>';
            var blob = new Blob(['\ufeff', html], { type: 'application/msword' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'ledger_report_format_1_' + new Date().toISOString().slice(0, 10) + '.doc';
            link.click();
        });
    </script>
@endpush
