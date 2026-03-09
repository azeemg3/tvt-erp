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
                            <li class="breadcrumb-item">Leads</li>
                            <li class="breadcrumb-item active">All Leads</li>
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
                            <h3 class="card-title">All Leads</h3><br>
                            <form id="search-form">
                            <div class="row filter-section" style="display: none;">
                                <div class="col-md-2 form-group">
                                    <input type="text" name="df" class="date form-control form-control-sm" placeholder="Date From" autocomplete="off">
                                </div>
                                <div class="col-md-2 form-group">
                                    <input type="text" name="dt" class="date form-control form-control-sm" placeholder="Date to" autocomplete="off">
                                </div>
                                <div class="col-md-2 form-group">
                                    <input type="text" name="mobile" class="form-control form-control-sm" placeholder="Mobile">
                                </div>
                                <div class="col-md-2 form-group">
                                    <input type="text" name="contact_name" class="form-control form-control-sm" placeholder="Contact Name">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="get_data(1)"><i class="fa fa-search"></i> </button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Lead ID</th>
                                    <th>Contac Name</th>
                                    <th>Mobile</th>
                                    <th>Lead Spo</th>
                                    <th>Takenover Date</th>
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
        get_data();
        function get_data(page){
            $("#loader").show();
            $.ajax({
                url:"{{ url('lms/get_all_leads') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#search-form").serialize(),
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].contact_name+'</td>';
                        htmlData+='<td>'+data.data[i].mobile+'</td>';
                        htmlData+='<td></td>';
                        htmlData+='<td>'+data.data[i].updated_at+'</td>';
                        htmlData+='<td>'+lsb(data.data[i].status)+'</td>';
                        htmlData+='<td>';
                        @can('lead_edit')
                        htmlData+='<a  class="btn btn-primary btn-xs" href="javascript:void(0)" onclick="edit('+data.data[i].id+')"><i class="fa fa-edit"></i> </a>';
                        @endcan
                            @can('lead_delete')
                        htmlData+=' <a  class="btn btn-danger btn-xs" href="javascript:void(0)" onclick="del_rec(\''+data.data[i].id+'\', \'{{ url('Hr/designation/') }}/'+data.data[i].id+'\')"><i class="fa fa-trash"></i> </a>';
                        @endcan
                        htmlData+=' <a class="btn btn-primary btn-xs" href="{{ url('lms/lead/') }}/'+data.data[i].id+'"><i class="fa fa-eye"></i></a>';
                        htmlData+='</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    $("#loader").hide();
                    if(data.total>0) {
                        pagination(data.total, data.per_page, data.current_page, data.to, get_data);
                    }
                }
            })
        }
    </script>
@endsection<!-- jQuery -->