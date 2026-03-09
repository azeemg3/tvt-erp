
<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="{{ URL::asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <title>Head Office-Invoice Print</title>
</head>
<body>
<div class="page-footer">
    <table class="footer" style="width: 100%; font-family: sans-serif;border-top: 1px solid #000;">
        <tr>
            <td style="padding-top: 10px;padding-bottom: 10px;text-align: left;font-size: 12px;">Powered By: Al-Hussain Int</td>
            <td style="padding-top: 10px;padding-bottom: 10px;text-align: center;font-size: 12px;">Website: www.uotrips.com</td>
            <td style="padding-top: 10px;padding-bottom: 10px;text-align: right;font-size: 12px;">Contact No: +92 021 35210452 - +92 333 2071887</td>
        </tr>
    </table>
</div>
<style>
    .page-footer,.page-footer-space  {
        height: 34px;
    }

    .page-footer {
        position:absolute;
        bottom: 0;
        width: 99%;
    }
    .bg-dg{ background-color: silver}
    @media print{
        @page {margin: 0 0.5cm; margin-top: 20px;}
        html, body {
            margin: 0;
            padding: 0;
        }
        .col-md-12{ margin-top: 20px !important;}
        .page-footer{ display: block; position: absolute; width: 100% !important;}
        table td,th{font-size: 10px !important; -webkit-print-color-adjust: exact; }
    }
</style>
<div class="col-md-12" style="position: relative;min-height: 100%;height: 100%;">
    <table width="100%" style="font-family: sans-serif; line-height:1;">
        <tr>
            <td width="33.33%"><img src="{{ URL::asset('public/dist/img/logo.png') }}" width="150" /></td>
            <td width="33.33%" style="text-align: center;"><h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 14px; font-weight:600">Al-Hussain Int
                    <span style="font-size:14px;">(Head Office)</span></h4>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">101, 1st Floor Trade Tower Abdullah Haroon Road, Saddar, Karachi</p>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">
                    Phone: 4298765432</p>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Email: sales@uotrips.com</p>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Govt. Lic No:321, IATA No: 133, NTN: 85212</p></td>
            <td width="33.33%" style="text-align: right;">
                {{--<img src="../iyata_logo/iata.png" width="100" />--}}
            </td>
        </tr>
    </table>
    <table width="100%" style="font-family: sans-serif; margin-top: 20px;font-size: 12px">
        <tr>
            <td style="padding: 3px;width: 72%;text-align: left;"><b>To: {{ $to }}</b></td>
            <th>Invoice ID:&emsp;&emsp;{{ App\Helpers\CommonHelper::dsn($sale->id) }}</th>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <th>Invoice Date:&emsp;&emsp;{{ $sale->inv_date }}</th>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <th>Entered by:&emsp;&emsp;{{ $enter_by }}</th>
        </tr>
        <tr style="text-align: center;">
            <td colspan="2"><h4 style="margin-bottom: 0px;margin-top: 0px;font-size: 14px;padding: 7px 0px;font-weight: 600;">Ticket Invoice</h4></td>
        </tr>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 0px;font-size: 12px;" cellpadding="2">
        <thead>
        <tr style="border: 1px solid #000;">
            <th style="border: 1px solid #000;width:5%; text-align:center;">#</th>
            <th style="border: 1px solid #000; width:25%; text-align:center">Passenger Name</th>
            <th style="border: 1px solid #000;width:20%; text-align:center;">Ticket No</th>
            <th style="border: 1px solid #000; width:10%; text-align:center;">Flight No.</th>
            <th style="border: 1px solid #000; width:30%; text-align:center">Sector/Desc</th>
            <th style="border: 1px solid #000; width:10%; text-align:center;">Amount</th>
        </tr>
        </thead>
        <tbody>
        @php
            $net_total=0;
        @endphp
        @foreach($result as $item)
            @php
                $net_total+=$item->receiveable;
            @endphp
        <tr style="border: 1px solid #000;">
            <td style="border: 1px solid #000; text-align:center;">1</td>
            <td style="border: 1px solid #000;text-align:left">{{ $item->pax_name }}</td>
            <td style="border: 1px solid #000;text-align:center"><i class="fa fa-ticket" aria-hidden="true"></i> {{ $item->ticket_no }}</td>
            <td style="border: 1px solid #000; text-align:center;">
            </td>
            <td style="border: 1px solid #000;text-align:center">{{  strtoupper($item->sector) }}</td>
            <td style="border: 1px solid #000; text-align:center;">{{ $item->receiveable }}</td>
        </tr>
        @endforeach
        <tr style="border-top: 1px solid #000;">
            <td colspan="4" style="padding: 10px;text-align: left;">
                <u> {{ App\Helpers\Account::convertNumberToWord($net_total) }} </u></td>
            <th style="padding: 10px;text-align: right;"><u>Net Payable</u></th>
            <th style="text-align: center;"><u>{{ number_format($net_total,2) }}</u></th>
        </tr>
        </tbody>
        <tfoot style="border: 0px;">
        <tr>
            <td colspan="12"><div class="page-footer-space"></div></td>
        </tr>
        </tfoot>
    </table><br>
    <table style="width: 100%; font-family: sans-serif;position: relative;margin-top: 40px;font-size: 12px;">
        <tr>
            <th colspan="3" style="padding: 10px;padding-left: 3px; text-align: left;">Notes:</th>
        </tr>
        <tr>
            <td colspan="3" style="padding: 3px;text-align: left;">1. In case of any kind of discripancy, please contact within 24 hours via phone or e-mail.</td>
        </tr>
    </table>
</div>
</body>
</html>
