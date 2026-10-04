<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Wise Aging</title>
    <style>
        @page { margin: 10mm 8mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #111; }
        .top-header { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .top-header td { vertical-align: top; border: none; padding: 0; }
        .logo { max-width: 95px; max-height: 60px; }
        .company-name { font-size: 16px; font-weight: bold; color: #1a3a8a; margin: 0 0 2px; }
        .report-title { font-size: 12px; font-weight: bold; margin: 0 0 2px; }
        .dates { font-size: 10px; font-style: italic; margin: 0; }
        .client-box {
            background: #cfe8f5;
            border: 1px solid #9ec9df;
            padding: 6px 10px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            line-height: 1.35;
            min-width: 130px;
        }
        .print-meta { width: 100%; font-size: 9px; font-style: italic; margin: 4px 0 8px; border-collapse: collapse; }
        .print-meta td { border: none; padding: 0; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.data .section td {
            background: #6c757d;
            color: #fff;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            padding: 4px;
            border: 1px solid #5a6268;
        }
        table.data th {
            background: #d9d9d9;
            border: 1px solid #9a9a9a;
            padding: 4px 3px;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
        }
        table.data td {
            border: 1px solid #b0b0b0;
            padding: 3px 4px;
            vertical-align: top;
            font-size: 9px;
        }
        .right { text-align: right; white-space: nowrap; }
        .center { text-align: center; }
        .neg { color: #c00000; font-weight: bold; }
        .total td { background: #d9d9d9; font-weight: bold; }
        .client-total td { background: #bfbfbf; font-weight: bold; }
        .total-label { text-align: right; padding-right: 6px; }
    </style>
</head>
<body>
@php
    $fmtDate = function ($d) {
        if (!$d) return '';
        try { return \Carbon\Carbon::parse($d)->format('d/m/Y'); } catch (\Throwable $e) { return $d; }
    };
    $fmtAmt = function ($n) {
        $n = (float) $n;
        if (abs($n) < 0.005) return '';
        return number_format(round($n));
    };
    $fmtBal = function ($n) use ($fmtAmt) {
        $n = (float) $n;
        $text = $fmtAmt($n);
        if ($text === '') return '';
        if ($n < 0) return '<span class="neg">' . $text . '</span>';
        return $text;
    };
@endphp

<table class="top-header">
    <tr>
        <td style="width:18%;">
            @php
                $logoRel = ($company->logo !== null && $company->logo !== '') ? $company->logo : \App\Models\Company::DEFAULT_LOGO;
                $logoFile = public_path(preg_replace('#^public/#', '', $logoRel));
                if (!is_file($logoFile)) {
                    $logoFile = base_path($logoRel);
                }
            @endphp
            @if(is_file($logoFile))
                <img class="logo" src="{{ $logoFile }}" alt="">
            @endif
        </td>
        <td style="width:54%; text-align:center;">
            <div class="company-name">{{ $company->name }}</div>
            <div class="report-title">Invoice Wise Aging</div>
            <div class="dates">From : {{ $fmtDate($df) }} To : {{ $fmtDate($dt) }}</div>
        </td>
        <td style="width:28%; text-align:right;">
            <div class="client-box">
                <div>{{ $clientCode ?? '' }}</div>
                <div>{{ $clientName ?? $clientLabel }}</div>
            </div>
        </td>
    </tr>
</table>

<table class="print-meta">
    <tr>
        <td style="width:50%;">Print On : {{ $printOn }}</td>
        <td style="width:50%; text-align:center;">Print By : {{ $printedBy }}</td>
    </tr>
</table>

<table class="data">
    <thead>
    <tr class="section"><td colspan="8">Invoices/DN/UB</td></tr>
    <tr>
        <th style="width:16%;">Invoice No / Date / XO No</th>
        <th style="width:34%;">Name of Passenger / Remarks</th>
        <th>Net Invoice</th>
        <th>Less Refund</th>
        <th>Less: Receipts</th>
        <th>Add: Payment</th>
        <th>Balance Amount</th>
        <th>Days Over</th>
    </tr>
    </thead>
    <tbody>
    @forelse($invoices as $row)
        <tr>
            <td>
                {{ $row['doc_label'] ?? '' }}
                @if(!empty($row['xo_no']))
                    <br>XO: {{ $row['xo_no'] }}
                @endif
            </td>
            <td>
                {{ $row['passenger_remarks'] ?? '' }}
                @if(!empty($row['extra_remarks']))
                    <br>{{ $row['extra_remarks'] }}
                @endif
            </td>
            <td class="right">{{ $fmtAmt($row['net_invoice'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['less_refund'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['less_receipts'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['add_payment'] ?? 0) }}</td>
            <td class="right">{!! $fmtBal($row['balance_amount'] ?? 0) !!}</td>
            <td class="right">{{ !empty($row['days_over']) ? $row['days_over'] : '' }}</td>
        </tr>
    @empty
        <tr><td colspan="8" class="center">No invoice records for selected filters.</td></tr>
    @endforelse
    <tr class="total">
        <td colspan="2" class="total-label">Invoices/DN/UB Total :</td>
        <td class="right">{{ $fmtAmt($invoiceTotals['net_invoice'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($invoiceTotals['less_refund'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($invoiceTotals['less_receipts'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($invoiceTotals['add_payment'] ?? 0) }}</td>
        <td class="right">{!! $fmtBal($invoiceTotals['balance_amount'] ?? 0) !!}</td>
        <td></td>
    </tr>
    </tbody>
</table>

<table class="data">
    <thead>
    <tr class="section"><td colspan="8">Un-Adjusted Vouchers</td></tr>
    <tr>
        <th>Invoice No / Date / XO No</th>
        <th>Name of Passenger / Remarks</th>
        <th>Net Invoice</th>
        <th>Less Refund</th>
        <th>Less: Receipts</th>
        <th>Add: Payment</th>
        <th>Balance Amount</th>
        <th>Days Over</th>
    </tr>
    </thead>
    <tbody>
    @forelse($unadjusted as $row)
        <tr>
            <td>{{ $row['doc_label'] ?? '' }}</td>
            <td>{{ $row['passenger_remarks'] ?? '' }}</td>
            <td class="right">{{ $fmtAmt($row['net_invoice'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['less_refund'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['less_receipts'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['add_payment'] ?? 0) }}</td>
            <td class="right">{!! $fmtBal($row['balance_amount'] ?? 0) !!}</td>
            <td class="right">{{ !empty($row['days_over']) ? $row['days_over'] : '' }}</td>
        </tr>
    @empty
        <tr><td colspan="8" class="center">No un-adjusted vouchers.</td></tr>
    @endforelse
    <tr class="total">
        <td colspan="2" class="total-label">Un-Adjusted Vouchers Total :</td>
        <td class="right">{{ $fmtAmt($unadjustedTotals['net_invoice'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($unadjustedTotals['less_refund'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($unadjustedTotals['less_receipts'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($unadjustedTotals['add_payment'] ?? 0) }}</td>
        <td class="right">{!! $fmtBal($unadjustedTotals['balance_amount'] ?? 0) !!}</td>
        <td></td>
    </tr>
    <tr class="client-total">
        <td colspan="2" class="total-label">Client Total</td>
        <td class="right">{{ $fmtAmt($clientTotals['net_invoice'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($clientTotals['less_refund'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($clientTotals['less_receipts'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($clientTotals['add_payment'] ?? 0) }}</td>
        <td class="right">{!! $fmtBal($clientTotals['balance_amount'] ?? 0) !!}</td>
        <td></td>
    </tr>
    </tbody>
</table>
</body>
</html>
