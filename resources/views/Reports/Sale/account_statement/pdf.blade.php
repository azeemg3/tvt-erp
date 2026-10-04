<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $reportTitle }}</title>
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
            vertical-align: middle;
            font-size: 9px;
        }
        .right { text-align: right; white-space: nowrap; }
        .center { text-align: center; }
        .total td { background: #d9d9d9; font-weight: bold; }
        .total-label { text-align: right; padding-right: 6px; }
        .group-start td { border-top: 1px dashed #666; }
    </style>
</head>
<body>
@php
    $isTicket = ($reportMode ?? 'invoice') === 'ticket';
    $fmtDate = function ($d) {
        if (!$d) return '';
        try { return \Carbon\Carbon::parse($d)->format('d/m/Y'); } catch (\Throwable $e) { return $d; }
    };
    $fmtAmt = function ($n, $decimals = false) {
        $n = (float) $n;
        if (abs($n) < 0.005) return '';
        return $decimals ? number_format($n, 2) : number_format(round($n));
    };
    $prevDate = '';
    $prevInvoice = '';
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
            <div class="report-title">{{ $reportTitle }}</div>
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
    <tr class="section"><td colspan="{{ $isTicket ? 11 : 9 }}">Invoices</td></tr>
    <tr>
        <th>Date</th>
        <th>XO Number</th>
        <th>Invoice Number</th>
        <th>Name of Passenger</th>
        @if($isTicket)
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
    <tbody>
    @forelse($invoices as $i => $row)
        @php
            $dateVal = $fmtDate($row['date'] ?? '');
            $invNo = $row['invoice_number'] ?? '';
            $rowClass = '';
            if ($isTicket) {
                $showDate = $invNo !== $prevInvoice;
                $showInv = $invNo !== $prevInvoice;
                if ($i > 0 && $invNo !== $prevInvoice) $rowClass = 'group-start';
                $prevInvoice = $invNo;
            } else {
                $showDate = $dateVal !== $prevDate;
                $showInv = true;
                $prevDate = $dateVal;
            }
        @endphp
        <tr class="{{ $rowClass }}">
            <td class="center">{{ $showDate ? $dateVal : '' }}</td>
            <td class="center">{{ ($showInv || !$isTicket) ? ($row['xo_no'] ?? '') : '' }}</td>
            <td class="center">{{ $showInv ? $invNo : '' }}</td>
            <td>{{ $row['passenger_name'] ?? '' }}</td>
            @if($isTicket)
                <td class="center">{{ $row['ticket_number'] ?? '' }}</td>
                <td>{{ $row['sector'] ?? '' }}</td>
            @endif
            <td class="right">{{ $fmtAmt($row['fare'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['taxes'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['sp'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['kb'] ?? 0) }}</td>
            <td class="right">{{ $fmtAmt($row['net_amount'] ?? 0) }}</td>
        </tr>
    @empty
        <tr><td colspan="{{ $isTicket ? 11 : 9 }}" class="center">No invoices found for the selected filters.</td></tr>
    @endforelse
    <tr class="total">
        <td colspan="{{ $isTicket ? 6 : 4 }}" class="total-label">Invoice Total :</td>
        <td class="right">{{ $fmtAmt($invoiceTotals['fare'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($invoiceTotals['taxes'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($invoiceTotals['sp'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($invoiceTotals['kb'] ?? 0) }}</td>
        <td class="right">{{ $fmtAmt($invoiceTotals['net_amount'] ?? 0) }}</td>
    </tr>
    </tbody>
</table>

<table class="data">
    <thead>
    <tr class="section"><td colspan="7">Receipts/Payments</td></tr>
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
    <tbody>
    @forelse($receipts as $row)
        <tr>
            <td class="center">{{ $fmtDate($row['trans_date'] ?? '') }}</td>
            <td class="center">{{ $row['voucher_number'] ?? '' }}</td>
            <td class="center">{{ $row['invoice_number'] ?? '-' }}</td>
            <td class="center">{{ $row['cheque_number'] ?? '' }}</td>
            <td>{{ $row['remarks'] ?? '' }}</td>
            <td class="right">{{ $fmtAmt($row['receipts'] ?? 0, true) }}</td>
            <td class="right">{{ $fmtAmt($row['payments'] ?? 0, true) }}</td>
        </tr>
    @empty
        <tr><td colspan="7" class="center">No receipts/payments found for the selected filters.</td></tr>
    @endforelse
    <tr class="total">
        <td colspan="5" class="total-label">Total :</td>
        <td class="right">{{ $fmtAmt($receiptTotals['receipts'] ?? 0, true) }}</td>
        <td class="right">{{ $fmtAmt($receiptTotals['payments'] ?? 0, true) }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
