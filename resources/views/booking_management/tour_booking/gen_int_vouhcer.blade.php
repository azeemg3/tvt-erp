<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://accounts.7skysoft.com/assets/plugins/bootstrap/css/bootstrap.min.css">
    <title>Tour Voucher</title>
</head>
<body>
<style>
    .page-footer,  {
        height: 539px;
    }
    .page-footer {
        position:absolute;
        bottom: 0;
        width: 100%;
    }
    .bg-dg{ background-color: silver}
    .voucher_status{
        position: absolute; top: 40%; left: 30%; transform: rotate(-45deg); opacity: 0.2;
        font-size: 50px;
    }
</style>

@php
    $qc =new App\Helpers\QrCode;
    // Create RL Code
    $qc->URL(url(Request::path()));
    // Save QR Code
    $qc->QRCODE(400,$booking_details->booking_no);
@endphp
<div class="col-md-12" style="position: relative;min-height: 100%;height: 100%; float: left; width: 100% !important;">
    <h4 style="font-size: 14px;text-align: center">HUSSAIN INTERNATIONAL TRAVEL & TOURS</h4><br>
    <table width="100%" style="font-family: sans-serif;line-height: 1.2">
        <tr>
            <td width="40%" style="text-align: left;"><h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 14px;">Client: {{ $booking_details->customer_name }}</h4>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Client Email: {{ $booking_details->email }}</p>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Phone: {{ $booking_details->phone }}</p>
                <h6>Booking Status:@if ($booking_details->status==1)Approved @else Pending @endif</h6>
            <td width="">
                <img src="http://192.168.0.150/uotrips/storage/app/qr-codes/{{ $booking_details->booking_no }}.png" width="100" />
            </td>
            <td width="33.33%" style="text-align: right;">
                <img src="{{ URL::asset('public/dist/img/hussain-logo.jpeg') }}" width="100" />
                {{--<p style="font-size: 12px;"> (A Project of Hussain Int)</p>--}}
                <br>
                Voucher#: {{ $booking_details->booking_no }}

            </td>
        </tr>
    </table>
    {{--<h3 class="voucher_status">@if($flight->status==1) Approved @else Pending @endif</h3>--}}
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th colspan="4" style="border: 1px solid #000; padding: 3px;text-align:center">Package Details</th>
        </tr>
        <tr style="border: 1px solid #000;">
            <th colspan="4" style="border: 1px solid #000; padding: 3px;text-align:center">
                {{ $pkg_details->pkg_name }}
            </th>
        </tr>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Duration</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Adult</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Child</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Infant</th>
        </tr>
        </thead>
        <tbody>
        <tr style="border: 1px solid #000;">
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $pkg_details->duration }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $booking_details->adult }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $booking_details->child }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $booking_details->infant }}</td>
        </tr>
        </tbody>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th colspan="3" style="border: 1px solid #000; padding: 3px;text-align:left">Pax Details</th>
        </tr>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Name</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Gender</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Pax Type</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Nationality</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Passport</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pax_details as $pax)
            <tr style="border: 1px solid #000;">
                <td style="border: 1px solid #000; padding: 2px;text-align:left;">{{ $pax->pax_name }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">@if($pax->gender==1)Male @else Female @endif</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">@if($pax->gender==1)Adult @elseif($pax->gender==2) Child @else Infant @endif</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ App\Models\Country::where('id',$pax->nationality)->value('name') }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $pax->passport }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th colspan="3" style="border: 1px solid #000; padding: 3px;text-align:left">Hotel Details</th>
        </tr>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Hotel Name</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Room Type</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Location</th>
        </tr>
        </thead>
        @php
            $hotels=json_decode($pkg_details->hotels,true);
        @endphp
        <tbody>
        @foreach($hotels as $hotel)
        <tr style="border: 1px solid #000;">
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ DB::table('hotels')->where('id',$hotel['hotel_name'])->value('name') }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ DB::table('room_types')->where('id', $hotel['room_type'])->value('name') }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ DB::table('cities')->where('id',$hotel['hotel_city'])->value('name') }}</td>
        </tr>
            @endforeach
        </tbody>
    </table>
    @php
        $transports=json_decode($pkg_details->transports,true);
    @endphp
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th colspan="3" style="border: 1px solid #000; padding: 3px;text-align:left">Transport Details</th>
        </tr>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">City</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Transport</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Sector</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transports as $transport)
            <tr style="border: 1px solid #000;">
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ DB::table('cities')->where('id',$transport['city'])->value('name') }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ App\Helpers\CommonHelper::get_veh_types($transport['transport']) }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $transport['sector'] }}</td>


            </tr>
        @endforeach
        </tbody>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;" cellpadding="5">
        <tr style="background: lightgrey">
            <td align="left">
                <span style="padding: 10px;">
                    {!! $pkg_details->ground_handeling_details !!}
                </span>

            </td>
        </tr>
    </table><br>
</div>
<p style="width:100%;position: absolute;bottom: 0; text-align: center">
    <br>System Support by Uotrips</p>
</body>
</html>
