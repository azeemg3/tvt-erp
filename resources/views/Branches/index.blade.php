@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Branches</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Company Setup</li>
                            <li class="breadcrumb-item active">Branch List</li>
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
                                    <input type="text" class="form-control form-control-sm" placeholder="Search with Name">
                                </div>
                                <div class="col-md-2">
                                    <button type="text" class="btn btn-flat btn-xs btn-dark" onclick="add_new()"><i class="fas fa-search"></i> </button>
                                </div>
                            </div>
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Branch Name</th>
                                    <th>Branch Manager</th>
                                    <th>Branch Phone</th>
                                    <th>Branch Email</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        {{--<div class="card-footer clearfix">--}}
                        {{--<ul class="pagination pagination-sm m-0 float-right">--}}
                        {{--<li class="page-item"><a class="page-link" href="#">«</a></li>--}}
                        {{--<li class="page-item active"><a class="page-link" href="#">1</a></li>--}}
                        {{--<li class="page-item"><a class="page-link" href="#">»</a></li>--}}
                        {{--</ul>--}}
                        {{--</div>--}}
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
    @include('Branches.modal')
    {{--<script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>--}}
    <script>
        function add_new() {
            $("#new").modal();
        }
        function save_rec() {
            $.ajax({
                url:"{{ route('continents.store') }}",
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
                url:"{{ url('get_agent') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td><a href="view.html" class="text-gray-800 text-hover-primary mb-1">'+data.data[i].full_name+'</a></td>';
                        htmlData+='<td>'+data.data[i].email+'</td>';
                        htmlData+='<td>'+data.data[i].phone_no+'</td>';
                        htmlData+='<td>'+data.data[i].address+'</td>';
                        htmlData+='<td>'+data.data[i].created_at.split('T')+'</td>';
                        htmlData+='<td class="text-end">';
                        htmlData+='<a class="btn btn-icon btn-active-light-primary w-30px h-30px" href="javascript:void(0)" onclick="edit('+data.data[i].id+')" data-bs-toggle="modal" data-bs-target="#new_agent"><i class="fa fa-edit"></i></a>';
                        htmlData+='<button type="button" onclick="del_rec(\''+data.data[i].id+'\', \'{{ url('/agents/') }}/'+data.data[i].id+'\')" class="btn btn-icon btn-active-light-primary w-30px h-30px deletebtn" data-kt-permissions-table-filter="delete_row"><i class="bi bi-trash"></i></button>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                }
            })
        }
        function edit(id) {
            $("#new_agent").modal();
            $.ajax({
                url: "{{ url('agents') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("#form input[name~='id']").val(data.id);
                    $("#form input[name~='full_name']").val(data.full_name);
                    $("#form input[name~='father_name']").val(data.father_name);
                    $("#form input[name~='nic']").val(data.nic);
                    $("#form input[name~='phone_no']").val(data.phone_no);
                    $("#form input[name~='email']").val(data.email);
                    $("#form input[name~='password']").val(data.password);
                    $("#form input[name~='address']").val(data.address);

                }
            })
        }
    </script>
@endsection<!-- jQuery -->