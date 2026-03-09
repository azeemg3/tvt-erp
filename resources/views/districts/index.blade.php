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
                            <li class="breadcrumb-item">Application Setup</li>
                            <li class="breadcrumb-item">Location Setup</li>
                            <li class="breadcrumb-item active">District</li>
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
                        <div class="card-body">
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>District</th>
                                    <th>Division</th>
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
    @include('districts.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_new() {
            $("#new").modal();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
            $('.select2').select2();
        }
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
        function save_rec() {
            $.ajax({
                url:"{{ route('district.store') }}",
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
                url:"{{ url('get_district') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].name+'</td>';
                        htmlData+='<td>'+(data.data[i].division!=null? data.data[i].division.name:'N/A')+'</td>';
                        htmlData+='<td>';
                        htmlData+='<a href="javascript:void(0)" onclick="edit('+data.data[i].id+')"><i class="fa fa-edit"> </a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                }
            })
        }
        function edit(id) {
            $("#new").modal();
            $.ajax({
                url: "{{ url('district') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("#form input[name~='id']").val(data.id);
                    $("#form input[name~='name']").val(data.name);
                    $("#form select[name~='DID']").val(data.DID);
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                }
            })
        }
    </script>
@endsection<!-- jQuery -->