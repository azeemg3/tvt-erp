@extends('layouts.app')

@section('content')
    <style>
        table th{
            text-transform: uppercase;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Reports</li>
                            <li class="breadcrumb-item">Umrah Report</li>
                            <li class="breadcrumb-item active">Departure Report</li>
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
                            <form id="form">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="df" class="form-control form-control-sm date" placeholder="From Date">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="text" name="dt" class="form-control form-control-sm date" placeholder="To Date">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-flat btn-xs btn-dark" onclick="get_data(1)"><i class="fas fa-search"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-xs btn-primary float-right exportToExcel"><i class="fa fa-file-excel"> Export</i> </button>
                            <table id="table2excel" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Group#</th>
                                    <th>Family Head</th>
                                    <th>Flight#</th>
                                    <th>Departure Date & Time</th>
                                    <th>Sector</th>
                                    <th>Terminal</th>
                                    <th>No of PAX</th>
                                    <th>Hotel</th>
                                    <th>Transport</th>
                                    <th>Transport Date & Time</th>
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
                url:"{{ url('reports/umrah/get_departure_report') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serialize(),
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr>';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>'+data.data[i].group_code+'</td>';
                        htmlData+='<td>'+data.data[i].pax_name+'</td>';
                        htmlData+='<td>'+data.data[i].dep_flight+'</td>';
                        htmlData+='<td>'+data.data[i].dep_date+' '+data.data[i].dep_dime+'</td>';
                        htmlData+='<td>'+data.data[i].city_name+'</td>';
                        htmlData+='<td>'+data.data[i].arr_sector+'</td>';
                        htmlData+='<td>'+data.data[i].total_pax+'</td>';
                        htmlData+='<td>'+data.data[i].hotel_name+'</td>';
                        htmlData+='<td>'+data.data[i].transport+'</td>';
                        htmlData+='<td>'+data.data[i].transport_time+'</td>';
                        htmlData+='<td></td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }
    </script>
    <script src="{{ URL::asset('public/export_excel/jquery.table2excel.js') }}"></script>
    <script>
        var jq = $.noConflict();
        jq(document).ready(function(){
            $(".exportToExcel").click(function () {
                jq("#table2excel").table2excel({
                    filename: "Employees.xls",
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: "departure_report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true,
                    preserveColors: true,
                });
            });
        });
    </script>
@endsection<!-- jQuery -->