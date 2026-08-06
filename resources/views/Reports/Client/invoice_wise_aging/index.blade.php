@extends('layouts.app')

@section('content')
    <style>
        .aging-report-header {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-bottom: 10px;
        }
        .aging-report-header .company-name {
            font-size: 16px;
            font-weight: bold;
        }
        .aging-report-title {
            font-size: 15px;
            font-weight: bold;
            margin: 8px 0 4px;
        }
        .aging-report-subtitle {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .aging-report-dates {
            font-size: 12px;
            margin-bottom: 8px;
        }
        .aging-print-meta {
            font-size: 11px;
            text-align: right;
            color: #444;
            margin-bottom: 6px;
        }
        #table2excel {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        #table2excel th,
        #table2excel td {
            border: 1px solid #666;
            padding: 4px 5px;
            vertical-align: top;
        }
        #table2excel thead th {
            background: #efefef;
            text-align: center;
            font-size: 10px;
            line-height: 1.25;
        }
        #table2excel .text-right { text-align: right; white-space: nowrap; }
        #table2excel .section-row td {
            font-weight: bold;
            background: #f5f5f5;
        }
        #table2excel .total-row td {
            font-weight: bold;
            background: #e9e9e9;
        }
        #table2excel .client-total td {
            font-weight: bold;
            background: #ddd;
            border-top: 2px solid #333;
        }
        .report-actions .btn { margin-right: 6px; margin-bottom: 6px; }
        .btn-excel { background-color: #17a2b8; border-color: #17a2b8; color: #fff; }
        .btn-word { background-color: #007bff; border-color: #007bff; color: #fff; }
        .btn-print-report { background-color: #8b1538; border-color: #8b1538; color: #fff; }
        .aging-footer {
            margin-top: 14px;
            font-size: 10px;
            color: #555;
            border-top: 1px solid #bbb;
            padding-top: 8px;
        }
        @media print {
            .no-report { display: none !important; }
            .report-show { display: block !important; }
            .main-footer, .main-header, .main-sidebar { display: none !important; }
            .content-wrapper { margin: 0 !important; }
            @page { size: landscape; margin: 8mm; }
        }
    </style>

    <div class="content-wrapper">
        <section class="content-header no-report">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item">Clients Report</li>
                    <li class="breadcrumb-item active">Invoice Wise Aging</li>
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
                        <div class="aging-print-meta report-show">
                            Print On: <span id="print_on"></span> &nbsp;|&nbsp; Print By: <span id="print_by"></span>
                        </div>

                        <div class="aging-report-header report-show">
                            <div class="company-name">{{ $company->name }}</div>
                            <div class="aging-report-title">Invoice Wise Aging <span id="client_label"></span></div>
                            <div class="aging-report-dates">
                                From : <span id="display_from">-</span> &nbsp; To : <span id="display_to">-</span>
                            </div>
                        </div>

                        <table id="table2excel" class="table report-show">
                            <thead>
                            <tr>
                                <th rowspan="2" style="width: 34%;">Name of Passenger / Remarks</th>
                                <th rowspan="2" style="width: 16%;">Invoice No / Date / XO No</th>
                                <th colspan="2">Less:</th>
                                <th rowspan="2">Balance<br>Amount</th>
                                <th rowspan="2">Less<br>Refund</th>
                                <th rowspan="2">Add:<br>Payment</th>
                                <th rowspan="2">Days<br>Over</th>
                                <th rowspan="2">Net<br>Invoice</th>
                            </tr>
                            <tr>
                                <th>Receipts</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody id="report_body">
                            <tr><td colspan="9" class="text-center text-muted">Select a client and run the report.</td></tr>
                            </tbody>
                        </table>

                        <div class="report-actions no-report mt-2">
                            <button type="button" class="btn btn-sm btn-excel exportToExcel"><i class="fa fa-file-excel"></i> Excel</button>
                            <button type="button" class="btn btn-sm btn-word exportToWord"><i class="fa fa-file-word"></i> Word</button>
                            <button type="button" id="printDiv" class="btn btn-sm btn-print-report"><i class="fa fa-print"></i> Print</button>
                        </div>

                        <div class="aging-footer report-show">
                            Software developed by http://www.talent4tech.pk
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
            if (!$('#df').val()) {
                $('#df').val('2010-07-01');
            }
            if (!$('#dt').val()) {
                $('#dt').val(isoFmt(today));
            }
            $('#display_from').text(formatDateDisplay($('#df').val()));
            $('#display_to').text(formatDateDisplay($('#dt').val()));
        }

        function formatDateDisplay(dateStr) {
            if (!dateStr) return '-';
            var parts = String(dateStr).substring(0, 10).split('-');
            if (parts.length === 3) {
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            }
            return dateStr;
        }

        function formatNumber(num) {
            num = parseFloat(num) || 0;
            if (Math.abs(num) < 0.005) {
                return '';
            }
            return num.toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0});
        }

        function formatSigned(num) {
            num = parseFloat(num) || 0;
            if (Math.abs(num) < 0.005) {
                return '0';
            }
            return num.toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 0});
        }

        function updatePrintMeta(name) {
            var now = new Date();
            var pad = function (n) { return ('0' + n).slice(-2); };
            $('#print_on').text(
                pad(now.getDate()) + '/' + pad(now.getMonth() + 1) + '/' + now.getFullYear()
            );
            $('#print_by').text(name || '{{ Auth::user()->name ?? '' }}');
        }

        function renderRows(rows) {
            var html = '';
            for (var i = 0; i < rows.length; i++) {
                var r = rows[i];
                var remarks = (r.passenger_remarks || '');
                if (r.extra_remarks) {
                    remarks += (remarks ? '<br>' : '') + (r.extra_remarks || '').replace(/\n/g, '<br>');
                }
                var doc = r.doc_label || '';
                if (r.xo_no) {
                    doc += (doc ? '<br>' : '') + 'XO: ' + r.xo_no;
                }
                html += '<tr>';
                html += '<td>' + remarks + '</td>';
                html += '<td>' + doc + '</td>';
                html += '<td class="text-right">' + formatNumber(r.less_receipts) + '</td>';
                html += '<td></td>';
                html += '<td class="text-right">' + formatNumber(r.balance_amount) + '</td>';
                html += '<td class="text-right">' + formatNumber(r.less_refund) + '</td>';
                html += '<td class="text-right">' + formatNumber(r.add_payment) + '</td>';
                html += '<td class="text-right">' + (r.days_over ? r.days_over : '') + '</td>';
                html += '<td class="text-right">' + formatSigned(r.net_invoice) + '</td>';
                html += '</tr>';
            }
            return html;
        }

        function totalRow(label, totals) {
            var html = '<tr class="total-row">';
            html += '<td colspan="2">' + label + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.less_receipts) + '</td>';
            html += '<td></td>';
            html += '<td class="text-right">' + formatNumber(totals.balance_amount) + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.less_refund) + '</td>';
            html += '<td class="text-right">' + formatNumber(totals.add_payment) + '</td>';
            html += '<td></td>';
            html += '<td class="text-right">' + formatSigned(totals.net_invoice) + '</td>';
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
                url: "{{ url('reports/client/get_invoice_wise_aging') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                dataType: 'JSON',
                data: $("#form").serialize(),
                success: function (data) {
                    $('#client_label').text(data.client_label || data.ledger_name || '');
                    updatePrintMeta(data.printed_by);

                    var html = '';
                    html += '<tr class="section-row"><td colspan="9">Invoices/DN/UB</td></tr>';
                    if (data.invoices && data.invoices.length) {
                        html += renderRows(data.invoices);
                    } else {
                        html += '<tr><td colspan="9" class="text-center text-muted">No invoice records for selected filters.</td></tr>';
                    }
                    html += totalRow('Invoices/DN/UB Total :', data.invoice_totals || {});

                    html += '<tr class="section-row"><td colspan="9">Un-Adjusted Vouchers</td></tr>';
                    if (data.unadjusted_vouchers && data.unadjusted_vouchers.length) {
                        html += renderRows(data.unadjusted_vouchers);
                    } else {
                        html += '<tr><td colspan="9" class="text-center text-muted">No un-adjusted vouchers.</td></tr>';
                    }
                    html += totalRow('Un-Adjusted Vouchers Total :', data.unadjusted_totals || {});

                    html += '<tr class="client-total">';
                    html += '<td colspan="2">Client Total</td>';
                    html += '<td class="text-right">' + formatNumber((data.client_totals || {}).less_receipts) + '</td>';
                    html += '<td></td>';
                    html += '<td class="text-right">' + formatNumber((data.client_totals || {}).balance_amount) + '</td>';
                    html += '<td class="text-right">' + formatNumber((data.client_totals || {}).less_refund) + '</td>';
                    html += '<td class="text-right">' + formatNumber((data.client_totals || {}).add_payment) + '</td>';
                    html += '<td></td>';
                    html += '<td class="text-right">' + formatSigned((data.client_totals || {}).net_invoice) + '</td>';
                    html += '</tr>';

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

        $('#printDiv').on('click', function () { window.print(); });

        $(document).on('click', '.exportToExcel', function () {
            $("#table2excel").table2excel({
                exclude: ".noExl",
                name: "Invoice Wise Aging",
                filename: "invoice_wise_aging_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                fileext: ".xls",
                preserveColors: true
            });
        });

        $(document).on('click', '.exportToWord', function () {
            var header = document.querySelector('.aging-report-header').outerHTML;
            var table = document.getElementById('table2excel').outerHTML;
            var footer = document.querySelector('.aging-footer').outerHTML;
            var html = '<html><head><meta charset="utf-8"></head><body>' + header + table + footer + '</body></html>';
            var blob = new Blob(['\ufeff', html], {type: 'application/msword'});
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'invoice_wise_aging_' + new Date().toISOString().slice(0, 10) + '.doc';
            link.click();
        });
    </script>
@endpush
