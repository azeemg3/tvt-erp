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
                            <li class="breadcrumb-item active">Hotel Room Types</li>
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
                        <div class="card-header">
                            <button class="btn btn-xs float-right filter filter-toggle">Filter <i class="fa fa-caret-down"></i> </button>
                            <h3 class="card-title">Room Type List</h3><br>
                            <div class="row filter-section" style="display: none;">
                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Room Type</th>
                                    <th>No Of Beds</th>
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
    @include('Setup.hotel_rooms.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_new() {
            $("#room-type").modal();
            document.getElementById("room-form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
            $('.select2').select2();
        }
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
        function save_room() {
            $("#loader").show();
            $.ajax({
                url:"{{ route('room_types.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#room-form").serialize(),
                success:function (data) {
                    $("#room-form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("room-form").reset();
                    get_data();
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
        get_data();
        function get_data(page){
            $.ajax({
                url:"{{ url('Application_Setup/get_room_types') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].name+'</td>';
                        htmlData+='<td>'+data.data[i].no_beds+'</td>';
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
            $("#room-type").modal();
            $.ajax({
                url: "{{ url('Application_Setup/room_types') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("#room-form input[name~='id']").val(data.id);
                    $("#room-form input[name~='name']").val(data.name);
                    $("#room-form input[name~='no_beds']").val(data.no_beds);
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                }
            })
        }
    </script>
@endsection<!-- jQuery -->