@extends('layouts.app')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
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
                            <li class="breadcrumb-item active">Mosque List</li>
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
                                <div class="col-md-12">
                                    <div class="btn-group float-right">
                                        <button class="btn btn-xs btn-info bnt-flat" onclick="add_new()">Add New</button>
                                        <button class="btn btn-xs btn-warning bnt-flat" onclick="import_excel()"><i class="fa fa-file-excel"></i> Import Excel</button>
                                    </div>
                                </div>
                            </div>
                            <table id="example2" class="table table-bordered table-hover data-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mosque Name</th>
                                    <th>Area</th>
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
    @include('mosques.modal')
    @include('mosques.excel-modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
    <script type="text/javascript">
        var table;
        $(function() {
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('get_mosques') }}",
                columns: [
                    {data: 'ID'},
                    {data: 'mosq_name'},
                    {data: 'area_name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

        });
    </script>
    <script>
        function add_new() {
            $("#new").modal();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
            $('.select2').select2();
        }
        function import_excel() {
            $("#excel").modal();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
            $('.select2').select2();
        }
        $('#form-excel').submit(function (e) {
            $("#loader").show();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ url('save_mosque_excel') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                dataType: "JSON",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    toastr.success('Operation Successfully..');
                    $("#excel").modal('hide');
                    $("#loader").hide();
                    get_data(1);
                }, error: function (ajaxcontent) {
                    vali = ajaxcontent.responseJSON.errors;
                    var errors = '';
                    $.each(vali, function (index, value) {
                        toastr.error(value);
                    });
                    $("#loader").hide();
                }
            })
        });
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
        function save_rec() {
            $.ajax({
                url:"{{ route('mosques.store') }}",
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
                url:"{{ url('get_mosques') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].name+'</td>';
                        htmlData+='<td>'+data.data[i].area.name+'</td>';
                        htmlData+='<td>';
                        htmlData+='<a href="javascript:void(0)" class="btn btn-info btn-xs" onclick="edit('+data.data[i].id+')"><i class="fa fa-edit"></i> </a>';
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].id+'\', \'{{ url('mosques') }}/'+data.data[i].id+'\')"><i class="fa fa-trash"></i> </a>';
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
                url: "{{ url('mosques') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("#form input[name~='id']").val(data.id);
                    $("#form input[name~='name']").val(data.name);
                    $("#form select[name~='ARID']").val(data.ARID);
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                }
            })
        }
    </script>
@endsection