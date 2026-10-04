@extends('layouts.app')

@php
    $reportTitle = $reportTitle ?? 'Account Statement';
    $reportSlug = $reportSlug ?? 'account_statement';
    $reportMode = $reportMode ?? 'invoice';
    $dataUrl = $dataUrl ?? url('reports/sale/get_account_statement_invoice_wise');
    $pdfUrl = $pdfUrl ?? url('reports/sale/pdf_account_statement_invoice_wise');
    $isTicketMode = $reportMode === 'ticket';
    $invoiceColspan = $isTicketMode ? 11 : 9;
    $receiptColspan = 7;
@endphp

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
        .stmt-top-header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .stmt-top-header td {
            vertical-align: top;
            border: none;
            padding: 0;
        }
        .stmt-logo img { max-width: 110px; max-height: 70px; }
        .stmt-company-name {
            font-size: 20px;
            font-weight: 700;
            color: #1a3a8a;
            margin: 0 0 2px;
            letter-spacing: 0.3px;
        }
        .stmt-report-title {
            font-size: 14px;
            font-weight: 700;
            color: #111;
            margin: 0 0 2px;
        }
        .stmt-dates {
            font-size: 12px;
            font-style: italic;
            margin: 0;
        }
        .stmt-client-box {
            display: inline-block;
            background: #cfe8f5;
            border: 1px solid #9ec9df;
            padding: 8px 14px;
            min-width: 160px;
            text-align: center;
            font-weight: 700;
            font-size: 13px;
            line-height: 1.35;
        }
        .stmt-print-meta {
            width: 100%;
            font-size: 11px;
            font-style: italic;
            margin: 6px 0 10px;
            border-collapse: collapse;
        }
        .stmt-print-meta td { border: none; padding: 0; }
        .stmt-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 14px;
        }
        .stmt-table .section-bar td {
            background: #6c757d;
            color: #fff;
            text-align: center;
            font-weight: 700;
            font-size: 12px;
            padding: 5px;
            border: 1px solid #5a6268;
        }
        .stmt-table thead th {
            background: #d9d9d9;
            border: 1px solid #9a9a9a;
            padding: 5px 4px;
            font-size: 10px;
            font-weight: 700;
            text-align: center;
            white-space: nowrap;
        }
        .stmt-table tbody td {
            border: 1px solid #b0b0b0;
            padding: 4px 5px;
            vertical-align: middle;
        }
        .stmt-table .text-right { text-align: right; white-space: nowrap; }
        .stmt-table .text-center { text-align: center; }
        .stmt-table .group-start td { border-top: 1px dashed #666; }
        .stmt-table .total-row td {
            background: #d9d9d9;
            font-weight: 700;
            border: 1px solid #9a9a9a;
        }
        .stmt-table .empty-row td {
            text-align: center;
            color: #777;
            padding: 12px;
        }
        .stmt-total-label { text-align: right !important; padding-right: 8px !important; }
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
            table.report-show, table.stmt-table, table.stmt-top-header, table.stmt-print-meta { display: table !important; }
            .content-wrapper { margin: 0 !important; padding: 0 !important; }
            .main-footer, .main-header, .main-sidebar, .card { border: none !important; box-shadow: none !important; }
            .card-body { padding: 0 !important; }
            @page { size: landscape; margin: 8mm 8mm 14mm 8mm; }
            .stmt-table { font-size: 9px; }
            #report-area {
                min-height: auto;
                display: block;
                padding-bottom: 28px;
            }
            .report-footer {
                position: fixed;
                left: 0;
                right: 0;
                bottom: 0;
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
                    <li class="breadcrumb-item">Invoice Reports</li>
                    <li class="breadcrumb-item active">{{ $reportTitle }}</li>
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
                            <div class="col-md-4">
                                <select name="ledger" class="form-control form-control-sm select2" required>
                                    <option value="">Select Client</option>
                                    {!! App\Models\Accounts\TransactionAccount::client_dd() !!}
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
                        <table class="stmt-top-header report-show" id="report_header">
                            <tr>
                                <td style="width:18%;">
                                    <div class="stmt-logo">
                                        <img src="{{ $company->logo_url }}" alt="Logo" onerror="this.style.display='none'">
                                    </div>
                                </td>
                                <td style="width:54%; text-align:center;">
                                    <div class="stmt-company-name">{{ $company->name }}</div>
                                    <div class="stmt-report-title">{{ $reportTitle }}</div>
                                    <div class="stmt-dates">
                                        From : <span id="display_from">-</span> To : <span id="display_to">-</span>
                                    </div>
                                </td>
                                <td style="width:28%; text-align:right;">
                                    <div class="stmt-client-box" id="client_box">
                                        <div id="client_code">Select Client</div>
                                        <div id="client_name"></div>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <table class="stmt-print-meta report-show">
                            <tr>
                                <td style="width:50%;">Print On : <span id="print_on"></span></td>
                                <td style="width:50%; text-align:center;">Print By : <span id="print_by">{{ Auth::user()->name ?? '' }}</span></td>
                            </tr>
                        </table>

                        <table id="invoices_table" class="stmt-table report-show">
                            <thead>
                            <tr class="section-bar"><td colspan="{{ $invoiceColspan }}">Invoices</td></tr>
                            <tr>
                                <th>Date</th>
                                <th>XO Number</th>
                                <th>Invoice Number</th>
                                <th>Name of Passenger</th>
                                @if($isTicketMode)
                                    <th>Ticket Number</th>
                                    <th>Sector</th>
                                @endif
                                <th>Fare</th>
                                <th>Taxes (+)</th>
                                <th>SP (-)</th>
                                <th>KB (-)</th>
                                <th>Net Amount</th>
                            </tr>
                            </thead>
                            <tbody id="invoices_body">
                            <tr class="empty-row"><td colspan="{{ $invoiceColspan }}">Select a client and run the report.</td></tr>
                            </tbody>
                        </table>

                        <table id="receipts_table" class="stmt-table report-show">
                            <thead>
                            <tr class="section-bar"><td colspan="{{ $receiptColspan }}">Receipts/Payments</td></tr>
                            <tr>
                                <th>Trans. Date</th>
                                <th>Voucher Number</th>
                                <th>Invoice Number</th>
                                <th>Cheque Number</th>
                                <th>Remarks</th>
                                <th>Receipts (Credit)</th>
                                <th>Payments (Debit)</th>
                            </tr>
                            </thead>
                            <tbody id="receipts_body">
                            <tr class="empty-row"><td colspan="{{ $receiptColspan }}">Select a client and run the report.</td></tr>
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
        var reportMode = @json($reportMode);
        var invoiceColspan = {{ $invoiceColspan }};
        var receiptColspan = {{ $receiptColspan }};

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
            $('#display_from').text(formatDateDisplay($('#df').val()));
            $('#display_to').text(formatDateDisplay($('#dt').val()));
        }

        function formatDateDisplay(dateStr) {
            if (!dateStr) return '-';
            var parts = String(dateStr).substring(0, 10).split('-');
            if (parts.length === 3) return parts[2] + '/' + parts[1] + '/' + parts[0];
            return dateStr;
        }

        function formatAmount(num, withDecimals) {
            num = parseFloat(num) || 0;
            if (Math.abs(num) < 0.005) return '';
            if (withDecimals) {
                return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
            return Math.round(num).toLocaleString('en-US');
        }

        function updatePrintMeta(name) {
            var now = new Date();
            var pad = function (n) { return ('0' + n).slice(-2); };
            $('#print_on').text(pad(now.getDate()) + '/' + pad(now.getMonth() + 1) + '/' + now.getFullYear());
            if (name) $('#print_by').text(name);
        }

        function renderInvoiceRows(rows, totals) {
            var html = '';
            if (!rows || !rows.length) {
                html += '<tr class="empty-row"><td colspan="' + invoiceColspan + '">No invoices found for the selected filters.</td></tr>';
            } else {
                var prevDate = '';
                var prevInvoice = '';
                for (var i = 0; i < rows.length; i++) {
                    var r = rows[i];
                    var dateVal = formatDateDisplay(r.date);
                    var invNo = r.invoice_number || '';
                    var showDate = true;
                    var showInv = true;
                    var rowClass = '';

                    if (reportMode === 'ticket') {
                        showDate = invNo !== prevInvoice;
                        showInv = invNo !== prevInvoice;
                        if (i > 0 && invNo !== prevInvoice) rowClass = 'group-start';
                        prevInvoice = invNo;
                    } else {
                        showDate = dateVal !== prevDate;
                        prevDate = dateVal;
                    }

                    html += '<tr class="' + rowClass + '">';
                    html += '<td class="text-center">' + (showDate ? dateVal : '') + '</td>';
                    html += '<td class="text-center">' + ((showInv || reportMode !== 'ticket') ? (r.xo_no || '') : '') + '</td>';
                    html += '<td class="text-center">' + (showInv ? invNo : '') + '</td>';
                    html += '<td>' + (r.passenger_name || '') + '</td>';
                    if (reportMode === 'ticket') {
                        html += '<td class="text-center">' + (r.ticket_number || '') + '</td>';
                        html += '<td>' + (r.sector || '') + '</td>';
                    }
                    html += '<td class="text-right">' + formatAmount(r.fare, false) + '</td>';
                    html += '<td class="text-right">' + formatAmount(r.taxes, false) + '</td>';
                    html += '<td class="text-right">' + formatAmount(r.sp, false) + '</td>';
                    html += '<td class="text-right">' + formatAmount(r.kb, false) + '</td>';
                    html += '<td class="text-right">' + formatAmount(r.net_amount, false) + '</td>';
                    html += '</tr>';
                }
            }

            var t = totals || {};
            var labelColspan = reportMode === 'ticket' ? 6 : 4;
            html += '<tr class="total-row">';
            html += '<td colspan="' + labelColspan + '" class="stmt-total-label">Invoice Total :</td>';
            html += '<td class="text-right">' + formatAmount(t.fare, false) + '</td>';
            html += '<td class="text-right">' + formatAmount(t.taxes, false) + '</td>';
            html += '<td class="text-right">' + formatAmount(t.sp, false) + '</td>';
            html += '<td class="text-right">' + formatAmount(t.kb, false) + '</td>';
            html += '<td class="text-right">' + formatAmount(t.net_amount, false) + '</td>';
            html += '</tr>';
            return html;
        }

        function renderReceiptRows(rows, totals) {
            var html = '';
            if (!rows || !rows.length) {
                html += '<tr class="empty-row"><td colspan="' + receiptColspan + '">No receipts/payments found for the selected filters.</td></tr>';
            } else {
                for (var i = 0; i < rows.length; i++) {
                    var r = rows[i];
                    html += '<tr>';
                    html += '<td class="text-center">' + formatDateDisplay(r.trans_date) + '</td>';
                    html += '<td class="text-center">' + (r.voucher_number || '') + '</td>';
                    html += '<td class="text-center">' + (r.invoice_number || '-') + '</td>';
                    html += '<td class="text-center">' + (r.cheque_number || '') + '</td>';
                    html += '<td>' + (r.remarks || '') + '</td>';
                    html += '<td class="text-right">' + formatAmount(r.receipts, true) + '</td>';
                    html += '<td class="text-right">' + formatAmount(r.payments, true) + '</td>';
                    html += '</tr>';
                }
            }
            var t = totals || {};
            html += '<tr class="total-row">';
            html += '<td colspan="5" class="stmt-total-label">Total :</td>';
            html += '<td class="text-right">' + formatAmount(t.receipts, true) + '</td>';
            html += '<td class="text-right">' + formatAmount(t.payments, true) + '</td>';
            html += '</tr>';
            return html;
        }

        function get_data() {
            var ledger = $('select[name="ledger"]').val();
            if (!ledger) {
                toastr.warning('Please select a client.');
                return;
            }
            $("#loader").show();
            $('#display_from').text(formatDateDisplay($('input[name="df"]').val()));
            $('#display_to').text(formatDateDisplay($('input[name="dt"]').val()));

            $.ajax({
                url: "{{ $dataUrl }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                dataType: "JSON",
                data: $("#form").serialize(),
                success: function (data) {
                    $('#client_code').text(data.client_code || '');
                    $('#client_name').text(data.client_name || data.ledger_name || '');
                    updatePrintMeta(data.printed_by);
                    $('#invoices_body').html(renderInvoiceRows(data.invoices || [], data.invoice_totals || {}));
                    $('#receipts_body').html(renderReceiptRows(data.receipts || [], data.receipt_totals || {}));
                    $("#loader").hide();
                },
                error: function (xhr) {
                    $("#loader").hide();
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to load report data.';
                    toastr.error(msg);
                }
            });
        }

        function exportPdf() {
            var ledger = $('select[name="ledger"]').val();
            if (!ledger) {
                toastr.warning('Please select a client.');
                return;
            }
            var $form = $('<form>', { method: 'POST', action: @json($pdfUrl), target: '_blank' });
            $form.append($('<input>', { type: 'hidden', name: '_token', value: $('meta[name="csrf-token"]').attr('content') }));
            $form.append($('<input>', { type: 'hidden', name: 'df', value: $('input[name="df"]').val() }));
            $form.append($('<input>', { type: 'hidden', name: 'dt', value: $('input[name="dt"]').val() }));
            $form.append($('<input>', { type: 'hidden', name: 'ledger', value: ledger }));
            $form.appendTo('body').submit().remove();
        }

        $('#printDiv').on('click', function () { window.print(); });

        function emailReport() {
            var subject = encodeURIComponent('{{ $reportTitle }} - {{ $company->name }}');
            var body = encodeURIComponent(
                'Please find the {{ $reportTitle }}.\n\nClient: ' +
                ($('#client_code').text() + ' ' + $('#client_name').text()).trim() +
                '\nFrom: ' + $('#display_from').text() +
                '\nTo: ' + $('#display_to').text()
            );
            window.location.href = 'mailto:?subject=' + subject + '&body=' + body;
        }

        $(document).on('click', '.exportToExcel', function () {
            var $tmp = $('<table id="tmp_excel_export"></table>').appendTo('body').hide();
            $('#invoices_table tr').clone().appendTo($tmp);
            $tmp.append('<tr><td colspan="' + invoiceColspan + '"></td></tr>');
            $('#receipts_table tr').clone().appendTo($tmp);
            $tmp.table2excel({
                exclude: ".noExl",
                name: "{{ $reportTitle }}",
                filename: "{{ $reportSlug }}_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true,
                preserveColors: true
            });
            $tmp.remove();
        });

        $(document).on('click', '.exportToWord', function () {
            var header = document.getElementById('report_header').outerHTML;
            var meta = document.querySelector('.stmt-print-meta').outerHTML;
            var invoices = document.getElementById('invoices_table').outerHTML;
            var receipts = document.getElementById('receipts_table').outerHTML;
            var footer = document.getElementById('report_footer').outerHTML;
            var html = '<html><head><meta charset="utf-8"></head><body>' + header + meta + invoices + receipts + footer + '</body></html>';
            var blob = new Blob(['\ufeff', html], { type: 'application/msword' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = '{{ $reportSlug }}_' + new Date().toISOString().slice(0, 10) + '.doc';
            link.click();
        });
    </script>
@endpush
