@extends('layouts.app')

@section('content')
    <style>
        table th{
            text-transform: uppercase;
        }
        @media print {
            table, h4{ font-family: Calibri !important;}
            .print-header{ display: block !important;}
            .page-title, #search-form, .panel-heading, hr, .main-footer{
                display: none;}
            @page { size: auto;  margin: 0 auto}
            html, body {
                padding: 0;
                margin: 0;
            }
            th, td{ font-size: 12px; }
            .col-md-6{ width: 50% !important; float: left}
            .no-report{ display: none;}
            .report-show{
                display: block !important;
            }
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header no-report">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Reports</li>
                            <li class="breadcrumb-item active">Checkout Report</li>
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
                            <form id="form" class="no-report">
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
                            <div class="col-md-12 no-report">
                                <div class="btn-group float-right">
                                    <button type="button" class="btn btn-xs btn-primary exportToExcel"><i class="fa fa-file-excel"></i> Export </button>
                                    <button type="button" id="printDiv" class="btn btn-xs btn-default"><i class="fa fa-print"></i> </button>
                                </div>
                            </div>
                            {!! \App\Helpers\CommonHelper::print_header('Checkour Report') !!}
                            <table id="table2excel" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#Booking</th>
                                    <th>Group Code</th>
                                    <th>Guest Name</th>
                                    <th>Pax</th>
                                    <th>City</th>
                                    <th>Hotel</th>
                                    <th>Room Type</th>
                                    <th>Check in</th>
                                    <th>Check out</th>
                                    <th>Nights</th>
                                </tr>
                                </thead>
                                <tbody id="get_data"></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix no-report">
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
        function add_new() {
            $("#new").modal();
            $(".select2").select2();
            document.getElementById("form").reset();
            $("#form input[name~='id']").val(0);
            $("#new").find('.btn-success').text('Submit');
        }
        get_data();
        function get_data(page){
            $("#loader").show();

            $.ajax({
                url:"{{ url('reports/umrah/get_checkout_report') }}?page="+page,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                dataType:"JSON",
                data:$("#form").serialize(),
                success:function (data) {
                    htmlData='';
                    for(i in data.data){
                        htmlData+='<tr id="'+data.data[i].id+'">';
                        htmlData+='<td>'+(Number(i)+1)+'</td>';
                        htmlData+='<td>uotqp'+data.data[i].UID+'</td>';
                        htmlData+='<td>'+data.data[i].group_code+'</td>';
                        htmlData+='<td>'+data.data[i].pax_name+'</td>';
                        htmlData+='<td>'+data.data[i].total_pax+'</td>';
                        htmlData+='<td>'+data.data[i].city_name+'</td>';
                        htmlData+='<td>'+data.data[i].hotel_name+'</td>';
                        htmlData+='<td>'+data.data[i].rt+'</td>';
                        htmlData+='<td>'+data.data[i].checkin+'</td>';
                        htmlData+='<td>'+data.data[i].checkout+'</td>';
                        htmlData+='<td>'+data.data[i].nights+'</td>';
                        htmlData+='</tr>';
                    }
                    $("#get_data").html(htmlData);
                    pagination(data.total, data.per_page, data.current_page, data.to ,get_data);
                    $("#loader").hide();
                }
            })
        }
    </script>
    <script type="text/javascript">
        $('#printDiv').on('click', function(event) {
            window.print();
        });
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
                    filename: "checkout_report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
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