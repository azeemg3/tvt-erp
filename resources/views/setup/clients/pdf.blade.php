<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clients</title>
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
    <h2>Client List</h2>
    <p>Generated: {{ date('d M Y, h:i A') }}</p>
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Client Code</th>
            <th>Client Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Category</th>
            <th class="text-right">Credit Limit</th>
            <th class="text-right">Credit Days</th>
            <th>SPO</th>
            <th>Recovery Officer</th>
            <th>Marketing Officer</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($clients as $i => $client)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $client->client_code }}</td>
                <td>{{ $client->client_name }}</td>
                <td>{{ $client->mobile }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->category }}</td>
                <td class="text-right">{{ number_format((float) $client->credit_limit, 2) }}</td>
                <td class="text-right">{{ $client->credit_days }}</td>
                <td>{{ optional($client->spoAccount)->name }}</td>
                <td>{{ optional($client->recoveryOfficerAccount)->name }}</td>
                <td>{{ optional($client->marketingOfficerAccount)->name }}</td>
                <td>{{ (int) $client->status === 1 ? 'Active' : 'Inactive' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
