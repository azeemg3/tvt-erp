@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <link href="http://demos.codexworld.com/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.css" rel="stylesheet"/>
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
                            <li class="breadcrumb-item active">Transport Rate List</li>
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
                                        <select name="vendor" class="form-control form-control-sm select2">
                                            <option value="">Select Vendor</option>
                                            {!! App\Models\Accounts\TransactionAccount::vendor_dd() !!}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="from_city" class="form-control form-control-sm select2">
                                            <option value="">Select City</option>
                                            {!! App\Models\UmrahTransportCity::dropdown() !!}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="to_city" class="form-control form-control-sm select2">
                                            <option value="">Select City</option>
                                            {!! App\Models\UmrahTransportCity::dropdown() !!}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="transport_type" class="form-control form-control-sm select2">
                                            <option value="">Select Vehicle Type</option>
                                            {!! App\Helpers\CommonHelper::vehicle_types() !!}
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
                                    <th>From City</th>
                                    <th>To City</th>
                                    <th>Source</th>
                                    <th>Contact Number</th>
                                    <th>Transport Type</th>
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
    @include('Rate_setup.transport_rate.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="http://demos.codexworld.com/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.js"></script>
    <script>
        $(function () {
            $(".select2").select2();
        })
        var jq = $.noConflict();
        function add_new() {
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
                url:"{{ route('transport_rate.store') }}",
                headers: {'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:dataForm,
                success:function (data) {
                    jq("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
//                    document.getElementById("form").reset();
                    get_data();
                    jq("#loader").hide();
//                    jq('.langOpt3').multiselect( 'unload' );
//                    setTimeout(function(){
//                        jq('.langOpt3').multiselect({
//                            columns: 1,
//                            placeholder: 'Select Agents',
//                            search: true,
//                            selectAll: true
//                        });
//                    }, 500);
//                    $(".select2").select2({
//                        placeholder: "select"
//                    });
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
                url:"{{ url('Application_Setup/Rate_Setup/get_transport_rates') }}?page="+page,
                headers: {'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:jq("#search-form").serialize(),
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+text_month(data.data[i].transport_agents.month)+'</td>';
                        htmlData+='<td>'+data.data[i].from_city.name+'</td>';
                        htmlData+='<td>'+data.data[i].to_city.name+'</td>';
                        htmlData+='<td>'+data.data[i].source.Trans_Acc_Name+'</td>';
                        htmlData+='<td>'+data.data[i].contact_number+'</td>';
                        htmlData+='<td>'+vehicle_type(data.data[i].transport_type)+'</td>';
                        htmlData+='<td>';
                        htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit(' + data.data[i].id + ')"> Add Agent </a>';
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].id+'\', \'{{ url('Application_Setup/Rate_Setup/transport_rate') }}/'+data.data[i].id+'\')"><i class="fa fa-trash"></i> </a>';
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
                url: "{{ url('Application_Setup/Rate_Setup/transport_rate') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': jq('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data.res).length; i++){
                        jq("#form input[name~='"+Object.keys(data.res)[i]+"']").val(Object.values(data.res)[i]);
                        jq("#form select[name~='"+Object.keys(data.res)[i]+"']").val(Object.values(data.res)[i]);

                    }
                    if(data.res.status==0){
                        $("#approve-first").show();
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
                    jq("#new").find(".btn-success").text('Update');
                }
            })
        }
        function more_item() {
            jq(".more-item").append('<div class="row">' +
                '<div class="form-group col-md-6">'+
                '<select class="form-control form-control-sm select2 agent" name="agents[]">'+
                '{!! App\Models\Accounts\Agent::dropdown() !!}'+
                '</select>'+
                '</div>'+
                '<div class="form-group col-md-2">'+
                '<select class="form-control form-control-sm" name="markup_type[]">'+
                '<option value="1">%</option>'+
                '<option value="2">Fixed</option>'+
                '</select>'+
                '</div>'+
                '<div class="col-md-2">'+
                '<input type="text" name="markup_value[]" class="form-control form-control-sm" placeholder="Enter...">'+
                '</div>'+
                '<div class="form-group col-md-1">' +
                '<button type="button" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> </button>'+
                '</div>'+
                '</div>');
            jq(".select2").select2({
                placeholder: "Select",
            });
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
            jq(".day_rate").val(net_sale);
        }
        //approved rate index while sent from service providor
        function approved_rate() {
            $("#loader").show();
            let id=$("#form input[name~='id']").val();
            $.ajax({
                url:"{{ url('Application_Setup/Rate_Setup/approve_transport_rate') }}/"+id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"GET",
                dataType:"JSON",
                success:function (data) {
                    if(data==1) {
                        toastr.success('Approved Successfully..');
                        $("#approve-first").hide();
                    }
                    $("#loader").hide();
                },error:function(ajaxcontent) {
                    vali=ajaxcontent.responseJSON.errors;
                    var errors='';
                    $.each(vali, function( index, value ) {
                        $("#room-form input[name~='" + index + "']").css('border', '1px solid red');
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        }
    </script>
@endsection<!-- jQuery -->
