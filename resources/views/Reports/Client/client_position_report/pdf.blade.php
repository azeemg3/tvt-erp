<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Client Position Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #111; }
        .top-header { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .top-header td { vertical-align: top; border: none; padding: 0; }
        .logo { max-width: 95px; max-height: 60px; }
        .company-name { font-size: 15px; font-weight: bold; color: #1a3a8a; margin: 0 0 2px; text-align: center; }
        .report-title { font-size: 11px; font-weight: bold; margin: 0; text-align: center; }
        .print-meta { width: 100%; font-size: 9px; margin: 4px 0 6px; border-collapse: collapse; }
        .print-meta td { border: none; padding: 0; }
        .currency { font-size: 9px; font-weight: bold; margin-bottom: 4px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th {
            background: #d9d9d9;
            border: 1px solid #9a9a9a;
            padding: 3px 2px;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }
        table.data td {
            border: 1px solid #b0b0b0;
            padding: 2px 3px;
            vertical-align: middle;
            font-size: 8px;
        }
        .activity { background: #cfcfcf; }
        .right { text-align: right; white-space: nowrap; }
        .center { text-align: center; }
        .neg { color: #c00000; font-weight: bold; }
        .total td { background: #d9d9d9; font-weight: bold; }
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
        if (abs($n) < 0.005) return '0.00';
        $text = number_format(abs($n), 2);
        if ($n < 0) return '<span class="neg">(' . $text . ')</span>';
        return $text;
    };
    $openLabel = $fmtDate($df);
    $closeLabel = $fmtDate($dt);
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
        <td style="width:64%;">
            <div class="company-name">{{ $company->name }}</div>
            <div class="report-title">
                Client Position Report For the period From {{ $openLabel }} To {{ $closeLabel }}
            </div>
        </td>
        <td style="width:18%;"></td>
    </tr>
</table>

<table class="print-meta">
    <tr>
        <td style="width:40%;">Print By : {{ $printedBy }}</td>
        <td style="width:30%; text-align:center;">Print On : {{ $printOn }}</td>
        <td style="width:30%; text-align:right;">Category : {{ $categoryLabel ?? 'All' }}</td>
    </tr>
</table>

<div class="currency">PKR &nbsp; Pak Rupees</div>

<table class="data">
    <thead>
    <tr>
        <th rowspan="2">Client Account</th>
        <th rowspan="2">Client Name</th>
        <th rowspan="2">Contact No.</th>
        <th rowspan="2">Opening Bal.<br>On {{ $openLabel }}</th>
        <th colspan="7" class="activity">Activity during the period</th>
        <th rowspan="2">Closing Bal.<br>Of {{ $closeLabel }}</th>
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
    <tbody>
    @forelse($rows as $row)
        <tr>
            <td class="center">{{ $row['client_account'] ?? '' }}</td>
            <td>{{ $row['client_name'] ?? '' }}</td>
            <td class="center">{{ $row['contact_no'] ?? '' }}</td>
            <td class="right">{!! $fmtAmt($row['opening_balance'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($row['invoice'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($row['debit_note'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($row['void_refund'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($row['bookings'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($row['cancellations'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($row['receipts'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($row['payments'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($row['closing_balance'] ?? 0) !!}</td>
        </tr>
    @empty
        <tr><td colspan="12" class="center">No client position activity for selected filters.</td></tr>
    @endforelse
    @if(count($rows))
        <tr class="total">
            <td colspan="3" class="right">Client Receivable :</td>
            <td class="right">{!! $fmtAmt($totals['opening_balance'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($totals['invoice'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($totals['debit_note'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($totals['void_refund'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($totals['bookings'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($totals['cancellations'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($totals['receipts'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($totals['payments'] ?? 0) !!}</td>
            <td class="right">{!! $fmtAmt($totals['closing_balance'] ?? 0) !!}</td>
        </tr>
    @endif
    </tbody>
</table>
</body>
</html>
