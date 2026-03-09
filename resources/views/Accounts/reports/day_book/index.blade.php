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
                            <li class="breadcrumb-item">Accounts</li>
                            <li class="breadcrumb-item">Reports</li>
                            <li class="breadcrumb-item active">Day Book</li>
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
                            <button class="btn btn-xs btn-primary float-right exportToExcel"><i class="fa fa-file-excel"> Export</i> </button>
                            <table id="table2excel" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#Entry ID</th>
                                    <th>Transaction Date</th>
                                    <th>Entry Type</th>
                                    <th>Amount</th>
                                    <th>Entry By</th>
                                    <th>Entry Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($res as $item)
                                    <tr>
                                        <td>{{ App\Helpers\CommonHelper::dsn($item->trans_code) }}</td>
                                        <td>{{ $item->trans_date }}</td>
                                        <td>{{ App\Helpers\Account::vt($item->vt) }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>Admin</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td><button onclick="view({{ $item->trans_code }})" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> </button> </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
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
    @include('Accounts.reports.day_book.modal')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ URL::asset('public/export_excel/jquery.table2excel.js') }}"></script>
    <script>
        function view(tc) {
            $("#new").modal();
            $("#loader").show();
            $.ajax({
                url:"{{ url('Accounts/reports/view_account_day_book') }}/"+tc,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"GET",
                dataType:"JSON",
                success:function (data) {
                    var htmlData='';
                    var dr=0;
                    var cr=0;
                    for(i in data){
                        if(data[i].dr_cr==1){
                            dr+=Number(data[i].amount);
                        }
                        if(data[i].dr_cr==2){
                            cr+=Number(data[i].amount);
                        }
                        htmlData+='<tr>';
                            htmlData+='<td>'+(Number(i)+1)+'</td>';
                            htmlData+='<td>'+data[i].trans_acc.Trans_Acc_Name+'</td>';
                            htmlData+='<td>'+data[i].narration+'</td>';
                            htmlData+='<td>'+(data[i].dr_cr==1?data[i].amount:'')+'</td>';
                            htmlData+='<td>'+(data[i].dr_cr==2?data[i].amount:'')+'</td>';
                        htmlData+='</tr>';
                    }
                    htmlData+='<tr>';
                        htmlData+='<th style="text-align: right" colspan="3">Total</th>';
                        htmlData+='<th>'+dr+'</th>';
                        htmlData+='<th>'+cr+'</th>';
                    htmlData+='</tr>';
                    $("#vd").html(htmlData);
                    $("#loader").hide();
                }
            })
        }
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

        });
    </script>
    <script>
        var jq = $.noConflict();
        jq(document).ready(function(){
            $(".exportToExcel").click(function () {
                jq("#table2excel").table2excel({
                    filename: "Employees.xls",
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "trailBalance" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true,
                });
            });
        });
    </script>
@endsection