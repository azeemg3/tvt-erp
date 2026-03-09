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
                            <li class="breadcrumb-item">Agent</li>
                            <li class="breadcrumb-item active">Agent Commission</li>
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
                            {{--<div class="row">--}}
                            {{--<div class="col-md-2">--}}
                            {{--<input type="text" class="form-control form-control-sm" placeholder="Search with Name">--}}
                            {{--</div>--}}
                            {{--<div class="col-md-2">--}}
                            {{--<button type="text" class="btn btn-flat btn-xs btn-dark"><i class="fas fa-search"></i> </button>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SubAdmin</th>
                                    <th>Product</th>
                                    <th>Base Currency</th>
                                    <th>Commission Amount</th>
                                    <th>Agent Commission</th>
                                    <th>GO Commission</th>
                                    <th>Validity</th>
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
            <!-- /.col -->
    </div>
    <!-- /.row -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('agents.agent_commission.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="http://demos.codexworld.com/multi-select-dropdown-list-with-checkbox-jquery/jquery.multiselect.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
            $('#reservation').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });
            $('#reservation').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
            });
            get_data(1);
        });
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"{{ url('agent_management/get_agent_commission') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].agent.agent_name+'</td>';
                        htmlData+='<td>N/A</td>';
                        htmlData+='<td>'+data.data[i].currency.currency_symbol+'</td>';
                        htmlData+='<td>'+data.data[i].subadmin_commission+'</td>';
                        htmlData+='<td>'+data.data[i].agent_commission+'</td>';
                        htmlData+='<td>'+data.data[i].go_commission+'</td>';
                        htmlData+='<td>'+data.data[i].validity_from+'/'+data.data[i].validity_to+'</td>';
                        htmlData+='<td>';
                        htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit(' + data.data[i].id + ')"><i class="fa fa-edit"></i> </a>';
                        {{--htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].id+'\', \'{{ url('Hr/designation/') }}/'+data.data[i].id+'\')"><i class="fa fa-trash"></i> </a>';--}}
                            htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                    $(".tt").val(1);
                    $('.select2').select2();
                }
            });
        }
        var jq = $.noConflict();
        function add_new() {
            $("#new").modal();
            $(".select2").select2();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
            setTimeout(function(){
                jq('.langOpt3').multiselect({
                    columns: 1,
                    placeholder: 'Select Agents',
                    search: true,
                    selectAll: true
                });
            }, 500);
        }
        function save_rec() {
            jq("#loader").show();
            jq.ajax({
                url:"{{ route('agent_commission.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:jq("#form").serializeArray(),
                success:function (data) {
                    jq("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#new").modal('hide');
                    get_data();
                    jq("#loader").hide();
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

        function edit(id) {
            $("#new").modal();
            $.ajax({
                url: "{{ url('agent_management/agent_commission') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data).length; i++){
                        $("#form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    }
                    $("#langOpt3").val(data.SAID);
                    $("#form input[name~='validity']").val(data.validity_from+'/'+data.validity_to);
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                    setTimeout(function(){
                        jq('.langOpt3').multiselect({
                            columns: 1,
                            placeholder: 'Select Agents',
                            search: true,
                            selectAll: true
                        });
                    }, 500);
                }
            })
        }
    </script>
@endsection<!-- jQuery -->
