@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Umrah</li>
                            <li class="breadcrumb-item">Reservation</li>
                            <li class="breadcrumb-item active">Hotel Reservation</li>
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Source</th>
                                        <th>Brn</th>
                                        <th>Booking Date</th>
                                        <th>Hotel</th>
                                        <th>Check-In</th>
                                        <th>Nights</th>
                                        <th>Room Type</th>
                                        <th># of Rooms</th>
                                        <th># of Beds</th>
                                        <th data-toggle="tooltip" data-placement="top" title="" data-original-title="Total Capacity"><i class="fa fa-user"></i> </th>
                                        <th data-toggle="tooltip" data-placement="top" title="" data-original-title="Used Capacity For Visa"><i class="fa fa-user"></i> </th>
                                        <th data-toggle="tooltip" data-placement="top" title="" data-original-title="Used Capacity For Accommodation"><i class="fa fa-user"></i> </th>
                                        <th data-toggle="tooltip" data-placement="top" title="" data-original-title="Available Capacity"><i class="fa fa-user"></i> </th>
                                        <th>Amount </th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="get_data"></tbody>
                                </table>
                            </div>
                        </div>
                        {{--<!-- /.card-body -->--}}
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
    @include('umrah.reservations.hotel_reservation.modal')
    @include('cities.modal')
    @include('Setup.hotels.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        function add_new() {
            $("#hotel-reservation").modal();
            $(".select2").select2();
        }
        function save_rec() {
            $.ajax({
                url:"{{ route('hotel_reservation.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#hotel-reservation-form").serialize(),
                success:function (data) {
                    $("#hotel-reservation input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("hotel-reservation-form").reset();
                    $("#hotel-reservation").modal('hide');
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#hotel-reservation input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        }
        get_data();
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"{{ url('umrah/get_hotel_reservation') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#search-form").serialize(),
                success:function (data) {
                    htmlData='';
                    var j=data.per_page*data.current_page-50;
                    var k=data.per_page*data.current_page-50+1;
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(j)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].source.Trans_Acc_Name+'</td>';
                        htmlData+='<td>'+data.data[i].brn+'</td>';
                        htmlData+='<td>'+data.data[i].booking_date+'</td>';
                        htmlData+='<td>'+data.data[i].hotel.name+'</td>';
                        htmlData+='<td>'+data.data[i].checkin+'</td>';
                        htmlData+='<td>'+data.data[i].nights+'</td>';
                        htmlData+='<td>'+data.data[i].room.name+'</td>';
                        htmlData+='<td>'+data.data[i].no_room+'</td>';
                        htmlData+='<td>'+data.data[i].total_capacity+'</td>';
                        htmlData+='<td>'+data.data[i].total_capacity+'</td>';
                        htmlData+='<td>0</td>';
                        htmlData+='<td>0</td>';
                        htmlData+='<td>0</td>';
                        htmlData+='<td>'+Number(data.data[i].total_capacity)*Number(data.data[i].purchase_rate)+'</td>';
                        htmlData+='<td>';
                        htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit(' + data.data[i].id + ')"><i class="fa fa-edit"></i> </a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                        j++;
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }
        function add_transport_compnay(g) {
            if($(g).val()=='new') {
                $("#transport-company").modal();
            }
        }
        function save_transport_company() {
            $.ajax({
                url:"{{ route('transport_company.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#trans-comp-form").serialize(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    $("#transport-company").modal('hide');
                    $("#fetch_trans_company").append('<option selected value="'+data.id+'">'+data.name+'</option>');
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        }
        function save_rec() {
            $.ajax({
                url:"{{ route('hotel_reservation.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#hotel-reservation-form").serialize(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("hotel-reservation-form").reset();
                    $("#hotel-reservation").modal('hide');
                    get_data(1);
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#hotel-reservation-form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        }
        //============Add New Cities===
        function add_new_city(g) {
            if($(g).val()=='new') {
                $(".new-city").modal();
                $(".new-city").find('form').attr('id', 'city-form');
                $(".new-city").find('.btn-success').removeAttr('onclick').attr('onclick', 'save_city()');
            }
        }
        function save_city() {
            $.ajax({
                url:"{{ route('cities.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#city-form").serialize(),
                success:function (data) {
                    toastr.success('Operation Successfully..');
                    $(".new-city").modal('hide');
                    $("#hotel-reservation-form select[name~='city_id']").append('<option selected value="'+data.id+'">'+data.name+'</option>');
                    $("#loader").hide();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#city-form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                }
            })
        }
        // add new hotel
        function add_new_hotel(g) {
            if($(g).val()=='new') {
                $(".new-hotel").modal();
                $(".new-hotel").find('form').attr('id', 'hotel-form');
                $(".new-hotel").find('.btn-success').removeAttr('onclick').attr('onclick', 'save_hotel()');
            }
        }
        function save_hotel() {
            $("#loader").show();
            $.ajax({
                url:"{{ route('hotel.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#hotel-form").serialize(),
                success:function (data) {
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $(".new-hotel").modal('hide');
                    $("#hotel-reservation-form select[name~='hotel_id']").append('<option selected value="'+data.id+'">'+data.name+'</option>');
                    $("#loader").hide();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#hotel-form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        }
        function edit(id) {
            $("#hotel-reservation").modal();
            $.ajax({
                url: "{{ url('umrah/hotel_reservation') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data).length; i++){
                        $("#hotel-reservation-form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#hotel-reservation-form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    }
                    $('.select2').select2();
                }
            })
        }
    </script>
@endsection<!-- jQuery -->