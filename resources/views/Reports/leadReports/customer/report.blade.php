<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://accounts.7skysoft.com/assets/plugins/bootstrap/css/bootstrap.min.css">
    <title>Customer Lead Reports</title>
</head>
<body>
<style>
    .page-footer {
        position:relative;
        bottom: 0;
        width: 100%;
    }
    .bg-dg{ background-color: silver}
    @media print{
        #btns{ display:none;}
        @page {margin: 0 0.1cm; margin-top: 5px;}
        html, body {
            margin: 0;
            padding: 0;
        }
        /*.col-md-12{ margin-top: 20px !important;}*/
        /*.page-footer{ display: block; position: absolute}*/
        table td,th{font-size: 8px !important; -webkit-print-color-adjust: exact; }
    }
</style>
<div style="position: relative;min-height: 100%;height: 100%; float: left; width: 100% !important;">
    <table width="100%" style="font-family: sans-serif;line-height: 1.2">
        <tr>
            <td width="60%" style="text-align: left;">
                <h4 style="font-size: 14px;">UO Trips <span style="font-size: 10px">(Project of Hassain Int)</span></h4>
                <p style="font-size: 10px">101, 1st Floor Trade Tower Abdullah Haroon Road, Saddar, Karachi<br>
                    Phone: 4298765432<br>
                    Email: sales@uotrips.com
                </p>
            <td width="40%" style="text-align: right;">
                <img src="{{ URL::asset('public/dist/img/ur-owntrips-logo.jpeg') }}" width="150" />
                {{--<p style="font-size: 12px;"> (A Project of Hussain Int)</p>--}}
                {{--<br>--}}
                {{--Lead#: 01--}}

            </td>
        </tr>
        <tr>
            <td colspan="3" align="center"><u>Customer Lead Reports</u></td>
        </tr>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center;font-size: 10px">Lead#</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center;font-size: 10px">Client Name</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center;font-size: 10px">Lead Status</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center;font-size: 10px">Created By</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center;font-size: 10px">Taken By</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center;font-size: 10px">Total</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center;font-size: 10px">Receipt</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center;font-size: 10px">Balance</th>
        </tr>
        </thead>
        <tbody>
        @foreach($result as $item)
            <tr style="border: 1px solid #000;">
                <td style="border: 1px solid #000; padding: 2px;text-align:left;font-size: 10px">{!! App\Helpers\CommonHelper::dsn($item->id) !!}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:left;font-size: 10px">{{ $item->contact_name }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:left;font-size: 10px">{!! App\Helpers\CommonHelper::lead_status($item->status) !!}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:left;font-size: 10px">{{ $item->name }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:left;font-size: 10px">{{ $item->taken_by }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:left;font-size: 10px">{{ $item->total }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:left;font-size: 10px">{{ $item->receipt }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:left;font-size: 10px">{{ number_format(($item->total)-($item->receipt),2) }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
