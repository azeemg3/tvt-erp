<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Airlines</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { font-size: 11px; color: #222; }
        h2 { text-align: center; margin: 0 0 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 5px 6px; text-align: left; }
        thead th { background: #343a40; color: #fff; }
        tbody tr:nth-child(even) { background: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Airline List</h2>
    <p>Generated: {{ date('d M Y, h:i A') }}</p>
    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Airline Name</th>
            <th>IATA</th>
            <th>ICAO</th>
            <th>Numeric Code</th>
            <th>Country</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($airlines as $i => $airline)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $airline->name }}</td>
                <td>{{ $airline->iata_code }}</td>
                <td>{{ $airline->icao_code }}</td>
                <td>{{ $airline->numeric_code }}</td>
                <td>{{ optional($airline->countryInfo)->name }}</td>
                <td>{{ (int) $airline->status === 1 ? 'Active' : 'Inactive' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
