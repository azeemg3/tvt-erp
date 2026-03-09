<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://accounts.7skysoft.com/assets/plugins/bootstrap/css/bootstrap.min.css">
    <title>Hussain Int- Receipt Voucher</title>
</head>
<body>
<style>
    .page-footer,  {
        height: 539px;
    }

    .page-footer {
        position:relative;
        bottom: 0;
        width: 100%;
    }
    .bg-dg{ background-color: silver}
    @media print{
        #btns{ display:none;}
        @page {margin: 0 0.5cm; margin-top: 20px;}
        html, body {
            margin: 0;
            padding: 0;
        }
        .col-md-12{ margin-top: 20px !important;}
        .page-footer{ display: block; position: absolute}
        table td,th{font-size: 10px !important; -webkit-print-color-adjust: exact; }
    }
</style>
<div class="col-md-12" style="position: relative;min-height: 100%;height: 100%; float: left; width: 100% !important;">
    <table width="100%" style="font-family: sans-serif; line-height: 1">
        <tbody>
        <tr>
            <td width="15%"><img src="{{ URL::asset('public/dist/img/hussain-logo.jpeg') }}" width="120" /></td>
            <td width="85%" style="text-align: center;"><h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 14px;">HUSSAIN INTERNATIONAL TRAVEL & TOURS</h4>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;">Office 1 First Floor Trade Tower Abdullah Haroon Road,<br> Saddar, Karachi</p>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;"> Phone: +92 021 35210452</p>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;">Email: info@uotrips.com</p>
            </td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="3"><h4 style="margin-bottom: 15px;margin-top: 25px;font-size: 14px;border-bottom: 1px solid #000;border-top: 1px solid #000;padding: 7px 0px;"> Receipt Voucher</h4></td>
        </tr>
        </tbody>
    </table>
    <table width="100%" style="font-family: sans-serif;font-size: 12px">
        <tbody><tr>
            <td style="padding: 3px;width: 65%;text-align: left;"><strong>Voucher No</strong>: {{ $result[0]->RID }}</td>
            <th style="padding: 3px;width: 15%;text-align: left;">Print Date:</th>
            <td style="padding: 3px;width: 20%;text-align: left;">{{ date('d-m-Y') }}</td>
        </tr>
        </tbody>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Account Name</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Description</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach($result as $item)
        <tr style="border: 1px solid #000;">
        <td style="border: 1px solid #000; padding: 2px;text-align:left;">{{ $item->Trans_Acc_Name }}</td>
        <td style="border: 1px solid #000; padding: 2px;text-align:left;">{{ $item->narration }}</td>
        <td style="border: 1px solid #000; padding: 2px;text-align:right;">{{ $item->amount }}</td>
        </tr>
            @endforeach
        </tbody>
        <tfoot>
        <tr style="border-top: 1px solid #000;">
            <td colspan="3" style="padding: 10px;text-align: left;"> <strong>In Words: </strong><u> {{ App\Helpers\Account::convertNumberToWord($result[0]->amount) }} </u></td>
        </tr>
        </tfoot>
    </table>
    <br>
    <table style="width: 100%; font-family: sans-serif;text-align: center; border-collapse: collapse;font-size: 12px;">
        <tbody><tr>
            <td>_______________<br>Prepaid By</td>
            <td>_______________<br>Received By</td>
            <td>_______________<br>Approved By</td>
        </tr>
        </tbody></table>
        <p style="margin-bottom: 5px;font-size: 12px;margin-top: 5px;text-align: center;
position: absolute; bottom: 5px; left: 40%"><u>System Support by Uotrips</u></p>
</div>
</body>
</html>
