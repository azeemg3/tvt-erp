@extends('layouts.app')
@section('content')
    <link href="http://demos.codexworld.com/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.css" rel="stylesheet"/>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Application Setup</li>
                            <li class="breadcrumb-item">Rate Setup</li>
                            <li class="breadcrumb-item active">Hotel Rate List</li>
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
                                        <select name="city" class="form-control form-control-sm select2">
                                            <option value="">Select City</option>
                                            {!! App\Models\City::dropdown() !!}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="hotel_id" class="form-control form-control-sm select2">
                                            <option value="">Select Hotel</option>
                                            {!! App\Models\Hotel::dropdown() !!}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="room_type" class="form-control form-control-sm select2">
                                            <option value="">Select Room</option>
                                            {!! App\Helpers\CommonHelper::room_type() !!}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" onclick="get_data(1)" class="btn btn-flat btn-xs btn-info"><i class="fas fa-search"></i> </button>
                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Month</th>
                                    <th>Source Contact</th>
                                    <th>City</th>
                                    <th>Hotel Name</th>
                                    <th>Room Type</th>
                                    <th>Price</th>
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
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('providors.hotels.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{--<script src="http://demos.codexworld.com/includes/js/bootstrap.js"></script>--}}
    <script src="http://demos.codexworld.com/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.js"></script>
    <script>
        $(function () {
            $(".select2").select2();
        })
        var jq = $.noConflict();
        function add_new(g) {
            $("#new").modal();
            jq("#form input[name~='id']").val(0);
            document.getElementById('form').reset();
            $(".langOpt3 option").each(function () {
                $(this).removeAttr('selected');
            });
            jq('.langOpt3').multiselect( 'unload' );
            setTimeout(function(){
                jq('.langOpt3').multiselect({
                    columns: 1,
                    placeholder: 'Select Agents',
                    search: true,
                    selectAll: true
                });
            }, 500);
            $(".select2").select2({
                placeholder: "select"
            });
        }
        function save_rec() {
            jq("#loader").show();
            var dataForm = jq("#form").serializeArray();
            jq.ajax({
                url:"{{ route('hotel_providor.store') }}",
                headers: {'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:dataForm,
                success:function (data) {
                    jq("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    get_data();
                    jq("#loader").hide();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    jq.each(vali, function( index, value ) {
                        jq("#form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    jq("#loader").hide();
                }
            })
        }
        get_data();
        function get_data(page){
            jq("#loader").show();
            jq.ajax({
                url:"{{ url('providors/get_hotel_providor') }}?page="+page,
                headers: {'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:jq("#search-form").serialize(),
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    let mrkup=0;
                    let total_price=0;
                    for(i in data.data){
                        total_price=Number(data.data[i].net_purchase);
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+text_month(data.data[i].month)+'</td>';
                        htmlData+='<td>'+data.data[i].contact+'</td>';
                        htmlData+='<td>'+data.data[i].city.name+'</td>';
                        htmlData+='<td>'+data.data[i].hotel.name+'</td>';
                        htmlData+='<td>'+(data.data[i].rt!=null?data.data[i].rt.name:'')+'</td>';
                        htmlData+='<td>'+total_price+'</td>';
                        htmlData+='<td>'+(data.data[i].status==1?'Approved':'Pending')+'</td>';
//                        htmlData+='<td>'+jq.parseJSON(data.data[i].sigle_det.replaceAll("'", '')).net_sale+'</td>';
//                        htmlData+='<td>'+jq.parseJSON(data.data[i].double_det.replaceAll("'", '')).net_sale+'</td>';
//                        htmlData+='<td>'+jq.parseJSON(data.data[i].triple_det.replaceAll("'", '')).net_sale+'</td>';
//                        htmlData+='<td>'+jq.parseJSON(data.data[i].quad_det.replaceAll("'", '')).net_sale+'</td>';
//                        htmlData+='<td>'+jq.parseJSON(data.data[i].quint_det.replaceAll("'", '')).net_sale+'</td>';
//                        htmlData+='<td>'+jq.parseJSON(data.data[i].six_bed_det.replaceAll("'", '')).net_sale+'</td>';
//                        htmlData+='<td>'+jq.parseJSON(data.data[i].sharing_rate.replaceAll("'", '')).net_sale+'</td>';
                        htmlData+='<td>';
                        if(data.data[i].status===0) {
                            htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit(' + data.data[i].id + ')"><i class="fa fa-edit"></i> </a>';
                            htmlData += ' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\'' + data.data[i].id + '\', \'{{ url('Application_Setup/Rate_Setup/hotel_rate') }}/' + data.data[i].id + '\')"><i class="fa fa-trash"></i> </a>';
                        }else{
                            htmlData+='N/A';
                        }
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    jq("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    jq("#loader").hide();
                }
            })
        }
        function edit(id) {
            $("#new").modal();
            jq.ajax({
                url: "{{ url('Application_Setup/Rate_Setup/hotel_rate') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data.res).length; i++){
                        jq("#form input[name~='"+Object.keys(data.res)[i]+"']").val(Object.values(data.res)[i]);
                        jq("#form select[name~='"+Object.keys(data.res)[i]+"']").val(Object.values(data.res)[i]);
                    }
                    jq("#form select[name~='month']").val(data.agents[0].month);
                    jq("#form select[name~='markup_type']").val(data.agents[0].markup_type);
                    jq("#form input[name~='markup_value']").val(data.agents[0].markup_value);
                    var dateWiserate=$.parseJSON(data.agents[0].validity_date_rate.replaceAll("'", ''));
                    $.each(dateWiserate, function (index, value) {
                        jq(".validity_date_rate"+index).val(value);
                    });
                    $.each(data.agents, function (index, value) {
                        $(".langOpt3 option").each(function () {
                            if($(this).val()==value.agent){
                                $(this).attr('selected','selectd');
                            }
                        });
//                        jq("#form select[name~='"+Object.keys(data.res)[i]+"']").val(Object.values(data.res)[i]);
                    });
                    jq('.langOpt3').multiselect( 'unload' );
                    setTimeout(function () {
                        jq('.langOpt3').multiselect({
                            columns: 1,
                            placeholder: 'Select Agents',
                            search: true,
                            selectAll: true
                        });
                    },500);
                    $('.select2').select2();
                }
            });
        }
        function more_item(g) {
            jq('.langOpt3').multiselect( 'unload' );
            setTimeout(function(){
                jq(g).closest('.row').clone().appendTo(g.closest('.col-md-12'));
            }, 500);
            setTimeout(function(){
                jq('.langOpt3').multiselect({
                    columns: 1,
                    placeholder: 'Select Agents',
                    search: true,
                    selectAll: true
                });
            }, 500);
        }
        //toggle agent assign row
        jq(document).ready(function() {
            //set initial state.
            jq('.assign_to_agent').val(this.checked);
            jq('.assign_to_agent').change(function () {
                if(jq(this).is(":checked")) {
                    jq(".assign_to").show();
                }else{
                    jq(".assign_to").hide();
                }
            });
        });
        function calculate_rate(g) {
            var pruchase=jq(g).closest('.row').find('.purchase_price').val();
            var sale_tax=jq(g).closest('.row').find('.sale_tax').val();
            var vat=jq(g).closest('.row').find('.vat').val();
            var wh=jq(g).closest('.row').find('.wh').val();
            var oc=jq(g).closest('.row').find('.oc').val();
            var net_sale=Number(pruchase)+Number(sale_tax)+Number(vat)+Number(wh)+Number(oc);
            jq(g).closest('.row').find('.net_sale').val(net_sale);
            $(".single_bed_rate").val(net_sale);
        }
    </script>
@endsection<!-- jQuery -->
