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
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Agents</li>
                            <li class="breadcrumb-item active">Booking List</li>
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
                            <form id="search-form">
                                <div class="row">
                                    <div class="col-md-2">
                                        <select class="form-control form-control-sm select2" name="agent_id">
                                            <option value="">Select Agent</option>
                                            {!! App\Models\Accounts\Agent::dropdown() !!}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-flat btn-xs btn-dark" onclick="get_data(1)"><i class="fas fa-search"></i> </button>
                                    </div>
                                </div>
                            </form>
                            {{--<button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>--}}
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Agent</th>
                                    <th>Package Name</th>
                                    <th>Booking Date</th>
                                    <th>Start Date-End Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                </div>
                <!-- /.card -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{--@include('agents.orders.modal')--}}
    @include('agents.orders.edit-modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        get_data();
        $(function () {
            $('.select2').select2();
        });
        function save_rec() {
            $.ajax({
                url:"{{ route('orders.store') }}",
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
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"{{ url('agent_management/get_orders') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:$("#search-form").serialize(),
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].name+'</td>';
                        htmlData+='<td>'+data.data[i].pkg_name+'</td>';
                        htmlData+='<td>'+data.data[i].booking_date+'</td>';
                        htmlData+='<td>'+data.data[i].departure+'-'+data.data[i].arrival+'</td>';
                        htmlData+='<td>'+data.data[i].guest_price+'</td>';
                        htmlData+='<td>'+(data.data[i].status==1?'Approved':'Pending')+'</td>';
                        htmlData+='<td>';
                        htmlData += ' <a  class="btn btn-default btn-xs" href="javascript:void(0)" onclick="view('+data.data[i].id+')"><i class="fa fa-eye"></i> </a>';
                        htmlData += ' <a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit('+data.data[i].id+')"><i class="fa fa-edit"></i> </a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }
        function view(id) {
//            $("#loader").show();
            $("#view").modal();
            $.ajax({
                url:"{{ url('agent_management/orders') }}/"+id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"GET",
                dataType:"JSON",
                success:function (data) {
//                    $("#loader").hide();
//                    console.log(data.booking);
//                    $("")
                }
            })
        }
        function edit(id) {
            $("#loader").show();
            $("#edit-modal").modal();
            $.ajax({
                url: "{{ url('agent_management/orders') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("#form input[name~='id']").val(data.booking.id);
                    $("#booking").text(data.booking.id);
                    $("#booking_date").text(data.booking.booking_date);
                    $("#form select[name~='airline_id']").val(data.booking.airline_id);
                    $("#form input[name~='pnr']").val(data.booking.pnr);
                    $("#form input[name~='flight']").val(data.booking.flight);
                    $("#form input[name~='departure']").val(data.booking.departure);
                    $("#form input[name~='departure_time']").val(data.booking.departure_time);
                    $("#form input[name~='arrival']").val(data.booking.arrival);
                    $("#form input[name~='arrival_time']").val(data.booking.arrival_time);
                    var tHtml='';
                    for(i in data.traveller) {
                        tHtml += '<tr>';
                        tHtml += '<td>'+data.traveller[i].first_name+' '+data.traveller[i].last_name+'</td>';
                        tHtml += '<td>'+data.traveller[i].mobile+'</td>';
                        tHtml += '<td>'+data.traveller[i].iqama_border_no+'</td>';
                        tHtml += '<td>'+data.traveller[i].passport_number+'</td>';
                        tHtml += '<td>'+data.traveller[i].nationality.name+'</td>';
                        tHtml += '<td>'+data.traveller[i].ticket_no+'</td>';
                        tHtml += '</tr>';
                    }
                    $("#passport_img").html('<img src="'+data.traveller[0].passport_images.split(',')[0]+'" style="width: 100%">');
                    $("#nic_images").html('<img src="'+data.traveller[0].nic_images.split(',')[0]+'" style="width: 100%">');
                    $("#traveller").html(tHtml);
                    $("#form select[name~='hotel_type']").val(data.AccDetails.hotel_type);
                    $("#form input[name~='hotel_name']").val(data.AccDetails.hotel_name);
                    $("#form input[name~='checkin']").val(data.AccDetails.checkin.split(' ')[0]);
                    $("#form input[name~='checkin_time']").val(data.AccDetails.checkin.split(' ')[1]);
                    $("#form input[name~='checkout']").val(data.AccDetails.checkout.split(' ')[0]);
                    $("#form input[name~='checkout_time']").val(data.AccDetails.checkout.split(' ')[1]);
                    $("#form select[name~='transport_type']").val(data.transport.transport_type);
                    $("#form select[name~='city']").val(data.transport.city);
                    $('.select2').select2();
                    $("#loader").hide();
                }
            })
        }
    </script>
@endsection<!-- jQuery -->