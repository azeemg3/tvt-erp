<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://accounts.7skysoft.com/assets/plugins/bootstrap/css/bootstrap.min.css">
    <title>{{ $company->name }} - Receipt Voucher</title>
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
            <td width="15%"><img src="{{ $company->logo_url }}" width="120" /></td>
            <td width="85%" style="text-align: center;"><h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 14px;">{{ $company->name }}</h4>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;">{{ $company->address }}</p>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;"> Phone: {{ $company->phone }}</p>
                <p style="margin-bottom: 5px;font-size: 14px;margin-top: 5px;">Email: {{ $company->email }}</p>
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
        <table style="width: 100%; font-family: sans-serif; border-top: 1px solid #000; position: absolute; bottom: 5px; left: 0;">
            <tr>
                <td style="padding-top: 8px;padding-bottom: 8px;text-align: left;font-size: 12px;">Powered By: {{ $company->powered_by }}</td>
                <td style="padding-top: 8px;padding-bottom: 8px;text-align: center;font-size: 12px;">Website: {{ $company->website }}</td>
                <td style="padding-top: 8px;padding-bottom: 8px;text-align: right;font-size: 12px;">Contact No: {{ $company->contact_no }}</td>
            </tr>
        </table>
</div>
</body>
</html>
