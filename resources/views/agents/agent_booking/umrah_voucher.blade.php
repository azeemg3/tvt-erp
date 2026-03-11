<!doctype html>
<html style="height: 100%;box-sizing: border-box;">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://accounts.7skysoft.com/assets/plugins/bootstrap/css/bootstrap.min.css">
    <title>Umrah Voucher</title>
</head>
<body>
<style>
    .bg-dg{ background-color:white}
    .voucher_status{
        position: absolute; top: 30%; left: 30%; transform: rotate(-45deg); opacity: 0.2;
        font-size: 50px;
    }
    .col-md-12{ color: #0a0909; }
    .remarks p{ background: none !important; border: none !important;}
</style>

@php
    $qc =new App\Helpers\QrCode;
     // Create RL Code
    $qc->URL(url(Request::path()));
    // Save QR Code
    $qc->QRCODE(400,'uotrip00'.$flight->id.'');
@endphp
<div class="col-md-12" style="position: relative;min-height: 100%;height: 100%; float: left; width: 100% !important;">
    <h4 style="font-size: 14px;text-align: center">Tour Vision Travel Pvt Ltd</h4><br>
    <table width="100%" style="font-family: sans-serif;line-height: 1.2">
        <tr>
            <td width="40%" style="text-align: left;"><h4 style="margin-bottom: 10px;margin-top: 5px;font-size: 14px;">Client: {{ $agent->agent_name }}</h4>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Client Email: {{ $agent->agent_email }}</p>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Phone: {{ $agent->agent_mobile }}</p>
                <h6>Booking Status:@if($flight->status==1) Approved @else Pending @endif</h6>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Group Number: @if($group_details) {{ $group_details->group_code }} @endif</p>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Group Name: @if($group_details) {{ $group_details->group_name }} @endif</p>
                <p style="margin-bottom: 2px;font-size: 12px;margin-top: 2px;">Family Head: {{ $family_head }}</p>
            <td width="">
                <img src="{{ url('/storage/app/qr-codes/uotrip00') }}{{ $flight->id }}.png" width="100" />
            </td>
            <td width="33.33%" style="text-align: right;">
                <img src="{{ URL::asset('public/dist/img/hussain-logo.jpeg') }}" width="100" />
                {{--<p style="font-size: 12px;"> (A Project of Hussain Int)</p>--}}
                <br>
                Voucher#: uotqp{{ $flight->id }}
            </td>
        </tr>
    </table>
    <p style="font-size: 12px;text-align: center;"> {{ $ground_hand_comp }}</p>
    {{--<h3 class="voucher_status">@if($flight->status==1) Approved @else Pending @endif</h3>--}}
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th colspan="6" style="border: 1px solid #000; padding: 3px;text-align:center">Flight Details</th>
        </tr>
        <tr style="border: 1px solid #000;">
            <th colspan="6" style="border: 1px solid #000; padding: 3px;text-align:center">Arrival Details</th>
        </tr>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">PNR</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">#Flight</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">ETD</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">ETA</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Sector</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Terminal</th>
        </tr>
        </thead>
        <tbody>
        <tr style="border: 1px solid #000;">
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $flight->pnr }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $flight->arr_flight }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ date('d-m-Y',strtotime($flight->arr_dep_date))  }} {{  $flight->arr_dep_time }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ date('d-m-Y',strtotime($flight->arr_date))  }} {{  $flight->arr_time }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $flight->arr_sector }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $flight->city_name }}</td>
        </tr>
        </tbody>
        <thead>
        <tr style="border: 1px solid #000;">
            <th colspan="6" style="border: 1px solid #000; padding: 3px;text-align:center">Departure Details</th>
        </tr>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">PNR</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">#Flight</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">ETD</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">ETA</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Sector</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Terminal</th>
        </tr>
        </thead>
        <tbody>
        <tr style="border: 1px solid #000;">
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $flight->pnr }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $flight->dep_flight }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ date('d-m-Y',strtotime($flight->dep_date)) }} {{ $flight->dep_dime }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ date('d-m-Y',strtotime($flight->dep_arr_date)) }} {{ $flight->dep_arr_time }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $flight->dep_sector }}</td>
            <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $flight->dep_ter }}</td>
        </tr>
        </tbody>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th colspan="5" style="border: 1px solid #000; padding: 3px;text-align:center">Guest Details</th>
        </tr>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">#</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Name</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Gender</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">#passport</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">#Visa</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1; ?>
        @foreach($pax as $guest)
            <tr style="border: 1px solid #000;">
                <td style="border: 1px solid #000; padding: 2px;text-align:left;">{{ $i }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:left;">{{ strtoupper($guest->pax_name) }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">
                    @if($guest->gender==1) Male @endif
                    @if($guest->gender==2) Female @endif
                    @if($guest->gender==3) Other @endif
                </td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;"> {{ $guest->passport }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ \App\Helpers\CommonHelper::get_visa_no($guest->passport) }}</td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th colspan="7" style="border: 1px solid #000; padding: 3px;text-align:left">Hotel Details</th>
        </tr>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">City</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Hotel Name</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Room Type</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">#Room</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Checkin</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Nights</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Checkout</th>
        </tr>
        </thead>
        <tbody>
        @foreach($hotels as $hotel)
            <tr style="border: 1px solid #000;">
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $hotel->city_name }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $hotel->hotel_name }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ App\Helpers\CommonHelper::getroom_type($hotel->room_type) }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $hotel->room }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $hotel->checkin }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $hotel->nights }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $hotel->checkout }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;">
        <thead>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th colspan="6" style="border: 1px solid #000; padding: 3px;text-align:left">Transport Details</th>
        </tr>
        <tr style="border: 1px solid #000;" class="bg-dg">
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Date</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Time</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">From City</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">To City</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">Type</th>
            <th style="border: 1px solid #000; padding: 3px;text-align:center">#Vehicle</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transport as $trans)
            <tr style="border: 1px solid #000;">
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $trans->transport_date }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $trans->transport_time }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $trans->from_city }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ $trans->to_city }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">{{ App\Helpers\CommonHelper::get_veh_types($trans->transport_type) }}</td>
                <td style="border: 1px solid #000; padding: 2px;text-align:center;">@if(isset($trans->vehicle)) {{ $trans->vehicle }} @else 1 @endif</td>


            </tr>
        @endforeach
        </tbody>
    </table>
    <table style="width: 100%; font-family: sans-serif;text-align: center;border-collapse: collapse; margin-top: 10px;font-size: 12px;" cellpadding="5">
        <tr style="border: 1px solid;padding: 15px; background: lightgrey">
            <td align="left" style="padding: 5px !important;">
                <div class="bg-dg remarks" style="border: 1px solid;padding: 5px;">
                    {!! $flight->remarks !!}<br>
                    {!! $flight->other_ground_information !!}
                </div>

            </td>
        </tr>
    </table><br>
    <div class="col-md-12">
        <img src="{{ URL::asset('public/dist/img/text.jpg') }}" width="100%">
    </div>
</div>
<p style="width:100%;position: absolute;bottom: 0; text-align: center">
    <br>System Support by Uotrips</p>
</body>
</html>
