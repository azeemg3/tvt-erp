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
                            <li class="breadcrumb-item active">Trial Balance</li>
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
                            <h5 align="center"><span style="border-bottom: double">Trial Balance</span></h5>
                            <p style="font-size: 12px;text-align: center">As on {{ date('d-m-Y') }}</p>
                            <button class="btn btn-xs btn-primary float-right exportToExcel"><i class="fa fa-file-excel"> Export</i> </button>
                            <table id="table2excel" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="80%">Account Name</th>
                                    <th style="text-align: left">Debit</th>
                                    <th style="text-align: right">Credit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $dr=0; $cr=0; ?>
                                @foreach($result as $item)
                                    <?php
                                    $balance=App\Helpers\Account::ob(date('Y-m-d'), $item->id);
                                    if($balance>0){
                                        $dr+=$balance;
                                    }else{
                                        $cr+=$balance;
                                    }
                                    ?>
                                    <tr>
                                        <td>{{ $item->Trans_Acc_Name }}</td>
                                        <td style="text-align: left">@if($balance>0) {{ App\Helpers\Account::show_bal_format($balance) }} @else 0.00 @endif</td>
                                        <td style="text-align: right">@if($balance<0) {{ App\Helpers\Account::show_bal_format($balance) }} @else 0.00 @endif</td>
                                    </tr>
                                    @endforeach
                                <tr>
                                    <th>Total</th>
                                    <th style="border-bottom: double;border-top: double;text-align: right">{{ App\Helpers\Account::show_bal_format($dr) }}</th>
                                    <th style="border-bottom: double;border-top: double;text-align: right">{{ App\Helpers\Account::show_bal_format($cr) }}</th>
                                </tr>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ URL::asset('public/export_excel/jquery.table2excel.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

        });
        function get_data(){
            $("#loader").show();
            $.ajax({
                url:"{{ url('Accounts/reports/get_ledger') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:"POST",
                data:$("#form").serialize(),
                dataType:"JSON",
                success:function (data) {
                    $("#get_data").html(data.data);
                    $("#loader").hide();
                }
            })
        }
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