@extends('layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Umrah</li>
                            <li class="breadcrumb-item active">Transport Cycle</li>
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
                            <button class="btn btn-xs btn-dark float-right" onclick="add_new()">Add New</button>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cycle Type</th>
                                    <th>Route</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data">
                                </tbody>
                            </table>
                        </div>
                        {{--<!-- /.card-body -->--}}
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
    @include('umrah.transport_cycle.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_new() {
            $("#new").modal();
            $("select").select2();
        }
        function save_rec() {
            $.ajax({
                url:"{{ route('transport_cycle.store') }}",
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
                url:"{{ url('umrah/get_transport_cycle') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+(data.data[i].route_type==1?'Regualar Routes':'Special Routes')+'</td>';
                        htmlData+='<td>'+data.data[i].route+'</td>';
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
                url: "{{ url('umrah/transport_cycle') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $("#form input[name~='id']").val(data.id);
                    $("#form select[name~='route_type']").val(data.route_type);
                    route=data.route.split('•');
                    $('.select2').select2().val(route).trigger('change');
                }
            })
        }
        function more_transport_sector() {
            $(".more-tr-sectors").append('<div class="row">\
            <div class="col-md-5">\
            <div class="form-group">\
                <select name="from_city[]" class="form-control form-control-sm select3">\
                    <option value="">Select Sector</option>\
                    {!! App\Models\UmrahTransportCity::dropdown() !!}\
                </select>\
            </div>\
            </div>\
            <!--col-->\
        <div class="col-md-5">\
            <div class="form-group">\
        <select name="to_city[]" class="form-control form-control-sm select3">\
            <option value="">Select Sector</option>\
        {!! App\Models\UmrahTransportCity::dropdown() !!}\
        </select>\
        </div>\
        </div>\
        <!--col-->\
        <div class="col-md-1">\
            <div class="form-group">\
        <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </button>\
            </div>\
            </div>\
            <!--col-->\
            </div>\
            <!--row-->');
            $(".select3").select2();
            $('.date').daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                startDate: true,
                minYear: 1930,
                maxYear: parseInt(moment().format('YYYY'),10),
                locale: {
                    format: 'YYYY-MM-DD',
                },
            });
            $(".date").on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-M-DD'));
            });
            $(".date").attr("autocomplete", "off");
        }
    </script>
@endsection<!-- jQuery -->