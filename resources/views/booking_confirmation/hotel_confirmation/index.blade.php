@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item">Booking Confirmation</li>
                            <li class="breadcrumb-item active">Hotel Confirmation</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Hotel Confirmation List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-xs btn-primary float-right exportToExcel"><i class="fa fa-file-excel"> Export</i> </button>
                            <form id="search-form">
                            <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" placeholder="#Booking" name="voucher">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm date" autocomplete="off" placeholder="From Date" name="df">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm date" autocomplete="off" placeholder="To Date" name="dt">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" onclick="get_data(1)" class="btn btn-xs btn-info"><i class="fa fa-search"></i> </button>
                                        </div>
                                    </div>
                            </div>
                            </form>
                            <table id="table2excel" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#Booking</th>
                                    <th>Guest Name</th>
                                    <th>Pax</th>
                                    <th>City</th>
                                    <th>Hotel</th>
                                    <th>Check in</th>
                                    <th>Check out</th>
                                    <th>Nights</th>
                                    <th>Rate</th>
                                    <th>Total</th>
                                    <th>Remarks</th>
                                    <th>Acknowledge By</th>
                                    <th class="noExl" width="12%">Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data"></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="pagination-panel"></div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('booking_confirmation.hotel_confirmation.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ URL::asset('public/export_excel/jquery.table2excel.js') }}"></script>
    <script>
        function save_rec() {
            $.ajax({
                url:"{{ route('hotel_confirimation.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serialize(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#new").modal('hide');
                    get_data();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                }
            })
        }
        get_data();
        function get_data(page){
            $.ajax({
                url:"{{ url('BookingConfirmation/get_hotel_confirimation') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:$("#search-form").serialize(),
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'" class="'+(data.data[i].ack_by==null?'bg-warning':'')+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>uotqp'+data.data[i].UID+'</td>';
                        htmlData+='<td>'+data.data[i].pax_name+'</td>';
                        htmlData+='<td>'+data.data[i].total_pax+'</td>';
                        htmlData+='<td>'+data.data[i].city_name+'</td>';
                        htmlData+='<td>'+data.data[i].hotel_name+'</td>';
                        htmlData+='<td>'+data.data[i].checkin+'</td>';
                        htmlData+='<td>'+data.data[i].checkout+'</td>';
                        htmlData+='<td>'+data.data[i].nights+'</td>';
                        htmlData+='<td>'+data.data[i].h_rate+'</td>';
                        htmlData+='<td>'+data.data[i].total+'</td>';
                        htmlData+='<td>'+data.data[i].remarks+'</td>';
                        htmlData+='<td>'+data.data[i].ack_by+'</td>';
                        htmlData+='<td class="noExl">';
                        if(data.data[i].ack_by==null) {
                            htmlData += '<button class="btn btn-xs btn-primary" onclick="add_rate(\'' + data.data[i].id + '\', \'' + data.data[i].total_pax + '\', \'' + data.data[i].nights + '\', \'' + data.data[i].room_type + '\', \'' + data.data[i].room + '\', \'' + data.data[i].source + '\')">Add Rate </button>';
                            htmlData += ' <a href="{{ url('agent_management/agent_umrah/') }}/'+data.data[i].UID+'" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> </a>';
                        }else{
                            htmlData+='N/A';
                        }
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                }
            })
        }
        function add_rate(id, total_pax, total_nights, room_type, room, source) {
            $("#new").modal();
            $("#form input[name~='total_pax']").val(total_pax);
            $("#form input[name~='total_nights']").val(total_nights);
            $(".room_type").val(room_type);
            $("source").val(source);
            $("#form input[name~='total_room']").val(room);
            $("#form input[name~='UID']").val(id);
        }
        //total calculation
        function total_cal() {
            var total_pax=$("#form input[name~='total_pax']").val();
            var room_type=$("#form input[name~='room_type']").val();
            var total_nights=$("#form input[name~='total_nights']").val();
            var rate=$("#form input[name~='rate']").val();
            var room=$("#form input[name~='total_room']").val();
            if(room_type==12){
                $("#form input[name~='total']").val(Number(total_pax)*Number(total_nights)*Number(rate));
            }else{
                $("#form input[name~='total']").val(Number(room)*Number(total_nights)*Number(rate));
            }
        }
    </script>
    <script>
        var jq = $.noConflict();
        jq(document).ready(function(){
            $(".exportToExcel").click(function () {
                jq("#table2excel").table2excel({
                    filename: "Employees.xls",
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "hotel_confimation" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true,
                });
            });
        });
    </script>
@endsection<!-- jQuery -->