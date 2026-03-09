@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Ground Handling</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Application Setup</li>
                            <li class="breadcrumb-item">Rate Setup</li>
                            <li class="breadcrumb-item active">Ground Handle</li>
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
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="From Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="To Date">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Searh With Voucher#">
                                </div>
                                <div class="col-md-2">
                                    <button type="text" class="btn btn-flat btn-xs btn-dark"><i class="fas fa-search"></i> </button>
                                </div>
                            </div>
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company Name</th>
                                    <th>Contact Details</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data"></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="pagination pagination-sm m-0 float-right"></div>
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
    @include('Rate_setup.ground_handles.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_new() {
            $("#new").modal();
            $(".select2").select2();
        }
        function save_rec() {
            $("#loader").show();
            $.ajax({
                url:"{{ route('ground_handling_rate.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serializeArray(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#new").modal('hide');
                    get_data();
                    $("#loader").hide();
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
        get_data();
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"{{ url('Application_Setup/Rate_Setup/get_ground_handling_rate') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].comp_name+'</td>';
                        htmlData+='<td>'+data.data[i].contact_details+'</td>';
                        htmlData+='<td>'+data.data[i].rate+'</td>';
                        htmlData+='<td>';
                        htmlData += '<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit(' + data.data[i].id + ')"><i class="fa fa-edit"></i> </a>';
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].id+'\', \'{{ url('Application_Setup/Rate_Setup/ground_handling_rate') }}/'+data.data[i].id+'\')"><i class="fa fa-trash"></i> </a>';
                            htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }
        function edit(id) {
            $("#new").modal();
            $.ajax({
                url: "{{ url('Application_Setup/Rate_Setup/ground_handling_rate') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data).length; i++){
                        $("#form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#form textarea[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
//                        if(Object.keys(data)[i]=='assign_products'){
//                            prlength=Object.values(data)[i].split(',').length;
//                            for(j=0; j<prlength; j++){
//                                $(".form-check-input").each(function () {
//                                    if($(this).val()==Object.values(data)[i].split(',')[j]){
//                                        $(this).prop('checked',true);
//                                    }
//                                })
//                            }
//                        }
                    }
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                    $('.note-editable').html(data.contact_details);
                }
            })
        }
        function more_item() {
            $(".more-item").append('<div class="row">' +
                '<div class="form-group col-md-6">'+
                '<select class="form-control form-control-sm select2 agent" multiple>'+
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
            $(".select2").select2({
                placeholder: "Select",
            });
        }
        //toggle agent assign row
        $(document).ready(function() {
            //set initial state.
            $('.assign_to_agent').val(this.checked);
            $('.assign_to_agent').change(function () {
                if($(this).is(":checked")) {
                    $(".assign_to").show();
                }else{
                    $(".assign_to").hide();
                }
            });
        });
        function calculate_rate(g) {
            var pruchase=$(g).closest('.row').find('.purchase_price').val();
            var sale_tax=$(g).closest('.row').find('.sale_tax').val();
            var vat=$(g).closest('.row').find('.vat').val();
            var wh=$(g).closest('.row').find('.wh').val();
            var oc=$(g).closest('.row').find('.oc').val();
            var net_sale=Number(pruchase)+Number(sale_tax)+Number(vat)+Number(wh)+Number(oc);
            $(g).closest('.row').find('.net_sale').val(net_sale);
        }
    </script>
@endsection<!-- jQuery -->