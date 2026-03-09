@extends('layouts.app')


@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Header start -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item">User Management</li>
                                <li class="breadcrumb-item active">Roles</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- End start -->
            <div class="row">
                <!-- Form Control starts -->
                <div class="col-md-12">
                    <div class="card">
                        {{ $errors->first('name') }}
                        <form action="{{ route('roles.update', $role->id) }}" method="post">
                            @CSRF
                            {{ method_field('PUT') }}
                            <input type="hidden" name="id" value="{{ $role->id }}">
                            <div class="card-block">
                                <div class="col-sm-12 table-responsive pad0 card-body">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" placeholder="Role Name" name="name" value="{{ $role->name }}">
                                        </div>
                                    </div>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>#</th>
                                            <th>Menu Name</th>
                                            <th>View</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            <th>Approve</th>
                                            <th>Send</th>
                                            <th>Upload</th>
                                        </tr>
                                        <tbody>{!! $htmlData !!} </tbody>
                                    </table>
                                    <br>
                                    <button class="btn btn-sm btn-primary btn-flat float-right">Save</button>
                                </div>
                            </div>
                            <!--card-block-->
                        </form>
                    </div>
                    <!--card-->
                </div>
                <!-- Form Control ends -->
            </div>
        </div>
    </div>

    @include('Roles.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_new() {
            $("#new").modal();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
        }
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        });
        function save_rec() {
            $.ajax({
                url:"{{ route('permission.store') }}",
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
                url:"{{ url('Application_Setup/user_management/get_menu') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    $("#get_data").html(data.htmlData);
                }
            })
        }
        function edit(id) {
            $("#new").modal();
            $.ajax({
                url: "{{ url('Hr/department') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("#form input[name~='id']").val(data.id);
                    $("#form input[name~='name']").val(data.name);
                    $('.select2').select2();
                    $("#form").find(".btn-success").text('Update');
                }
            })
        }
    </script>
@endsection