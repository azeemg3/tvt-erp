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
                            <li class="breadcrumb-item">Bookings</li>
                            <li class="breadcrumb-item active">Tour Bookings</li>
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
                            <button class="btn btn-xs btn-primary float-right exportToExcel"><i class="fa fa-file-excel"> Export</i> </button>
                            <table id="table2excel" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#Booking</th>
                                    <th>Package</th>
                                    <th>Contact Person</th>
                                    <th>Contact Mobile</th>
                                    <th>Contact Email</th>
                                    <th>Adult/Child/Infant</th>
                                    <th>Payment Status</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="noExl">Action</th>
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
    @include('booking_management.tour-pax-modal')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ URL::asset('public/export_excel/jquery.table2excel.js') }}"></script>
    <script>
        get_data();
        function get_data(page){
            $.ajax({
                url:"{{ url('bookings/get_tour_booking') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData += '<tr id="' + data.data[i].id + '">';
                        htmlData += '<td>' + (Number(i) + 1) + '</td>';
                        htmlData += '<td>'+data.data[i].booking_no+'</td>';
                        htmlData += '<td>'+data.data[i].tour_pkg.pkg_name+'</td>';
                        htmlData += '<td>'+data.data[i].customer_name+'</td>';
                        htmlData += '<td>'+data.data[i].phone+'</td>';
                        htmlData += '<td>'+data.data[i].email+'</td>';
                        htmlData += '<td><a href="#" onclick="tour_pax_modal('+data.data[i].id +')">'+data.data[i].adult+'/'+data.data[i].child+'/'+data.data[i].infant+'</a></td>';
                        htmlData += '<td>'+(data.data[i].payment_status==0?'Pending':'Paid')+'</td>';
                        htmlData += '<td>'+data.data[i].receiveable_amout+'</td>';
                        htmlData += '<td class="status">'+(data.data[i].status==0?'Pending':'Approved')+'</td>';
                        htmlData += '<td class="noExl">';
                        {{--htmlData += ' <a  class="btn btn-primary btn-xs" href="{{ url('bookings/tour_booking_details/') }}/' + data.data[i].id + '"><i class="fa fa-eye"></i> Detail</a>';--}}
                        if(data.data[i].status==0) {
                            htmlData += ' <a href="javascirpt:void(0)" class="btn btn-success btn-xs" onclick="approve_booking('+data.data[i].id+')">Approve</a>';
                        }else{
                            htmlData += ' <a target="_blank" href="{{ url('gen_int_tour_voucher') }}/' + data.data[i].id + '""  class="btn btn-success btn-xs"><i class="fa fa-eye"> Voucher</a>';
                        }
                        htmlData += '</td>';
                        htmlData += '</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                }
            })
        }
        //approve booking
        function approve_booking(id) {
            $.ajax({
                url:"{{ url('bookings/app_int_tour') }}/"+id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"GET",
                success:function (data) {
                    if(data==1) {
                        $("#" + id).find('.status').text('Approved');
                    }else{
                        toastr.error('Something Wrong with your request!');
                    }
                }
            })
        }
        //open pax modal
        function tour_pax_modal(TID) {
            get_visitor_data(TID);
            $("#tour-pax-modal").modal();
            $("#TID").val(TID);
        }
        $(document).ready(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#pax-form').submit(function (e) {
                $("#loader").show();
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "{{ url('bookings/save_tour_pax') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $("#pax-form input[name~='id']").val(0);
                        toastr.success('Operation Successfully..');
                        htmlData = '';
                        for (i in data) {
                            htmlData += '<tr id="' + data[i].passport + '">';
                            htmlData += '<td>' + (Number(i) + 1) + '</td>';
                            htmlData += '<td>' + data[i].pax_name + '</td>';
                            htmlData+='<td>'+(data[i].gender==1?'Male':'Female')+'</td>';
                            htmlData+='<td>'+(data[i].pax_type==1?'Adult':'')+' '+(data[i].pax_type==2?'Child':'')+' '+(data[i].pax_type==3?'Infant':'')+'</td>';
                            htmlData += '<td>N/A</td>';
                            htmlData += '<td>' + data[i].passport + '</td>';
                            htmlData += '<td>';
                            // htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_pax(\'' + data[i].passport + '\')"><i class="fa fa-edit"></i> </a>';
                            htmlData += ' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\'' + data[i].passport + '\', \'{{ url('crm/save_umrah_pax/remove') }}/' + data[i].passport + '\')"><i class="fa fa-trash"></i> </a>';
                            htmlData += '</td>';
                            htmlData += '</tr>';
                        }
                        $("#get_pax_data").append(htmlData);
                        $("#loader").hide();
                    }, error: function (ajaxcontent) {
                        vali = ajaxcontent.responseJSON.errors;
                        var errors = '';
                        $.each(vali, function (index, value) {
                            $("#pax-form input[name~='" + index + "']").css('border', '1px solid red');
                            $("#pax-form select[name~='" + index + "']").css('border', '1px solid red');
                            toastr.error(value);
                        });
                        $("#loader").hide();
                    }
                })
            });
        });
        //fetch visitor data
        function get_visitor_data(TID) {
            $.ajax({
                url:"{{ url('bookings/get_tour_pax') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:{'TID':TID},
                success:function (data) {
                    htmlData='';
                    for(i in data){
                        htmlData+='<tr id="'+data[i].id+'">';
                        htmlData+='<td>'+Number(i+1)+'</td>';
                        htmlData+='<td>'+data[i].pax_name+'</td>';
                        htmlData+='<td>'+(data[i].gender==1?'Male':'Female')+'</td>';
                        htmlData+='<td>'+(data[i].pax_type==1?'Adult':'')+' '+(data[i].pax_type==2?'Child':'')+' '+(data[i].pax_type==3?'Infant':'')+'</td>';
                        htmlData+='<td>'+data[i].country.name+'</td>';
                        htmlData+='<td>'+data[i].passport+'</td>';
                        htmlData += '<td>';
                        // htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit_pax(\'' + data[i].id + '\')"><i class="fa fa-edit"></i> </a>';
                        htmlData += ' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\'' + data[i].id + '\', \'{{ url('bookings/delete_tour_pax') }}/' + data[i].id + '\')"><i class="fa fa-trash"></i> </a>';
                        htmlData += '</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_pax_data").html(htmlData);
                }
            })
        }
        //edit pax
        function edit_pax() {
            
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
@endsection
