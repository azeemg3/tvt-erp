<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vendors</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { font-size: 11px; color: #222; }
        h2 { text-align: center; margin: 0 0 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 5px 6px; text-align: left; }
        thead th { background: #343a40; color: #fff; }
        tbody tr:nth-child(even) { background: #f4f4f4; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Vendor / Supplier List</h2>
    <p>Generated: {{ date('d M Y, h:i A') }}</p>
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Vendor Code</th>
            <th>Vendor Name</th>
            <th>Vendor Type</th>
            <th>Contact Person</th>
            <th>Mobile</th>
            <th class="text-right">Credit Limit</th>
            <th class="text-right">Credit Days</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vendors as $i => $vendor)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $vendor->vendor_code }}</td>
                <td>{{ $vendor->vendor_name }}</td>
                <td>{{ $vendor->vendor_type }}</td>
                <td>{{ $vendor->contact_person }}</td>
                <td>{{ $vendor->mobile }}</td>
                <td class="text-right">{{ number_format((float) $vendor->credit_limit, 2) }}</td>
                <td class="text-right">{{ $vendor->credit_days }}</td>
                <td>{{ (int) $vendor->status === 1 ? 'Active' : 'Inactive' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
