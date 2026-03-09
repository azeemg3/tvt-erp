@extends('layouts.app')
@section('content')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
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
                            <li class="breadcrumb-item active">City List</li>
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-group float-right">
                                        <button class="btn btn-xs btn-info bnt-flat" onclick="add_new()">Add New</button>
                                        <button class="btn btn-xs btn-warning bnt-flat" onclick="import_excel()"><i class="fa fa-file-excel"></i> Import Excel</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>City Name</th>
                                    <th>Province</th>
                                    <th>Country</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            {{--<table id="example2" class="table table-bordered table-hover">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                            {{--<th>#</th>--}}
                            {{--<th>City Name</th>--}}
                            {{--<th>Province</th>--}}
                            {{--<th>Country</th>--}}
                            {{--<th>Action</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody id="get_data"></tbody>--}}
                            {{--</table>--}}
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
    @include('cities.modal')
    @include('cities.excel-modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js" defer></script>
    <script type="text/javascript">
        var table;
       $(function() {
            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('get_cities') }}",
                columns: [
                    {data: 'ID'},
                    {data: 'city_name'},
                    {data: 'pName'},
                    {data: 'country_name'},
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
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();
        });
        $('#form-excel').submit(function (e) {
            $("#loader").show();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ url('save_cities_excel') }}",
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
                   table;
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
        // get_data();
        function get_data(page){
            $.ajax({
                url:"{{ url('get_cities') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].name+'</td>';
                        htmlData+='<td>'+(data.data[i].province!=null? data.data[i].province.name:'N/A')+'</td>';
                        htmlData+='<td>'+(data.data[i].country!=null? data.data[i].country.name:'N/A')+'</td>';
                        htmlData+='<td>';
                        htmlData+='<a class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit('+data.data[i].id+')"><i class="fa fa-edit"></i> </a>';
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].id+'\', \'{{ url('cities') }}/'+data.data[i].id+'\')"><i class="fa fa-trash"></i> </a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                }
            })
        }
        function save_rec() {
            $.ajax({
                url:"{{ route('cities.store') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serialize(),
                success:function (data) {
                    $("#form input[name~='id']").val(0);
                    toastr.success('Operation Successfully..');
                    document.getElementById("form").reset();
                    $("#new").modal('hide');
                    table.ajax.reload(null, false);
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
        function edit(id) {
            $("#new").modal();
            $.ajax({
                url: "{{ url('cities') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("#form input[name~='id']").val(data.id);
                    $("#form input[name~='name']").val(data.name);
                    $("#form select[name~='CID']").val(data.CID);
                    $("#form select[name~='PID']").val(data.PID);
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                }
            })
        }
    </script>
@endsection<!-- jQuery -->