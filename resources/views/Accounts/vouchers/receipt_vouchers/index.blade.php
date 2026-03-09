@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Receipt Vouchers</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Accounts</li>
                            <li class="breadcrumb-item active">Receipt Voucher List</li>
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
                                    <th>Voucher#</th>
                                    <th>Trans Date</th>
                                    <th>Narration</th>
                                    <th>Amount</th>
                                    <th>Attachment</th>
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
    @include('Accounts.vouchers.receipt_vouchers.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_new() {
            $(".select2").select2();
            $("#new").modal();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
        }
        $(document).ready(function () {
            $(".client_inv").on("change",function () {
                var pt=$(this).closest('form').find('.pt').val();
                if(pt==1){
                    pt='Cash';
                }else if(pt==2){
                    pt='Cheque';
                }else if(pt==3){
                    pt='Online';
                }
                var client=$(this).find("option:selected").text();
                $(this).closest('form').find('.narration').val('Received '+pt+' From '+client);
            })
        });
        $("#form").submit(function (e) {
            $("#loader").show();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"{{ route('receipt_vouchers.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
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
        });
        get_data();
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"{{ url('Accounts/vouchers/get_receipt_vouchers') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].trans_code+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].trans_code+'</td>';
                        htmlData+='<td>'+data.data[i].trans_date+'</td>';
                        htmlData+='<td>'+data.data[i].remarks+'</td>';
                        htmlData+='<td>'+data.data[i].amount+'</td>';
                        if(data.data[i].attach_file==null){
                            htmlData += '<td>N/A</td>';
                        }else {
                            htmlData += '<td><a  class="btn btn-success btn-xs" href="' + data.data[i].attach_file + '" download><i class="fa fa-download"></i> Attached Document</a></td>';
                        }
                        htmlData+='<td>';
                        htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit(\''+data.data[i].trans_code+'\')"><i class="fa fa-edit"></i> </a>';
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].trans_code+'\', \'{{ url('Accounts/vouchers/receipt_vouchers') }}/'+data.data[i].trans_code+'\')"><i class="fa fa-trash"></i> </a>';
                        htmlData+=' <a  class="btn btn-default btn-xs" href="{{ url('Accounts/vouchers/receipt_vouchers') }}/'+data.data[i].trans_code+'" target="_blank"><i class="fa fa-print"></i> </a>';
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
                url: "{{ url('Accounts/vouchers/receipt_vouchers') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data).length; i++){
                        $("#form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#form textarea[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    }
                    $("#form input[name~='id']").val(data.trans_code);
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                        id=data.payment_from;
                        $.ajax({
                            url: "{{ url('Accounts/vouchers/fetch_client_inv') }}/"+id,
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function (data) {
                                var htmlData='<option value="">Select Invoice</option>';
                                for(i in data){
                                    htmlData+='<option value="'+data[i].id+'">'+data[i].id+'</option>';
                                }
                                $(".invoices").html(htmlData);
                            }
                        });
                        setTimeout(function (args) {
                            $("#form select[name~='SID']").val(data.SID);
                        },500);
                }
            })
        }
        //fetch invoice againsst client id
        $(document).ready(function () {
            $(".client_inv").change(function () {
                id=$(this).val();
                $.ajax({
                    url: "{{ url('Accounts/vouchers/fetch_client_inv') }}/"+id,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        var htmlData='<option value="">Select Invoice</option>';
                        for(i in data){
                            htmlData+='<option value="'+data[i].id+'">'+data[i].id+'</option>';
                        }
                        $(".invoices").html(htmlData);
                    }
                })
            });
            //fetch balance against invoice id
            $(".invoices").change(function () {
                id=$(this).val();
                $.ajax({
                    url: "{{ url('Accounts/vouchers/fetch_inv_balance') }}/"+id,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
                        $(".balance").val(data);
                    }
                })
            });
        });

    </script>
@endsection<!-- jQuery -->