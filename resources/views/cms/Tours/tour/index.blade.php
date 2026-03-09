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
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item">Tours</li>
                            <li class="breadcrumb-item active">Tour</li>
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
                            <a class="btn btn-xs btn-dark float-right" href="{{ route('tour.create') }}">Add New</a>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Package Name</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    <th>Location</th>
                                    <th>Validity</th>
                                    <th>Status</th>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function add_new() {
            $("#new").modal();
            $(".select2").select2();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
        }
        function save_rec() {
            $("#loader").show();
            $.ajax({
                url:"{{ route('trans_accounts.store') }}",
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
                url:"{{ url('cms/tours/get_tours') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].pkg_name+'</td>';
                        htmlData+='<td>'+data.data[i].duration+'</td>';
                        htmlData+='<td>'+data.data[i].starting_price+'</td>';
                        htmlData+='<td>'+data.data[i].country.name+'</td>';
                        htmlData+='<td>'+data.data[i].validity_from+'/'+data.data[i].validity_to+'</td>';
                        htmlData+='<td class="status">'+(data.data[i].status==0?'Pending':'Approved')+'</td>';
                        htmlData+='<td>';
                        htmlData += '<a href="{{ url('cms/tours/tour') }}/'+data.data[i].id+'/edit"  class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> </a>';
                        htmlData+=' <a  class="btn btn-default btn-xs" href="{{ url('cms/tours/tour') }}/'+data.data[i].id+'"><i class="fa fa-eye"></i> </a>';
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].id+'\', \'{{ url('cms/tours/tour/') }}/'+data.data[i].id+'\')"><i class="fa fa-trash"></i> </a>';
                        if(data.data[i].status==0) {
                            htmlData += ' <a  class="btn btn-success btn-xs" href="javascript:void(0)" onclick="approve(' + data.data[i].id + ')"><i class="fa fa-check"></i>App </a>';
                        }
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
                url: "{{ url('Accounts/trans_accounts') }}/" + id + "/edit",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    for (i=0; i<Object.keys(data).length; i++){
                        $("#form input[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                        $("#form select[name~='"+Object.keys(data)[i]+"']").val(Object.values(data)[i]);
                    }
                    $('.select2').select2();
                    $("#new").find(".btn-success").text('Update');
                }
            })
        }
        //approved packages
        function approve(id) {
            $.ajax({
                url: "{{ url('cms/tours/app_tour') }}/"+id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if(data==1){
                        $("#"+id).find('.status').text('Approved');
                    }
                }
            })
        }
    </script>
@endsection<!-- jQuery -->
