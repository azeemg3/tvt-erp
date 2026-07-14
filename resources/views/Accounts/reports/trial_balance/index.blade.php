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
                            <p style="font-size: 12px;text-align: center">As on {{ date('d-m-Y', strtotime($asOn)) }}</p>
                            @if(abs($dr - $cr) > 0.01)
                                <div class="alert alert-warning py-2">
                                    Debit and Credit totals do not match (difference: {{ number_format(abs($dr - $cr), 2) }}).
                                    Check Umrah / voucher postings for unbalanced entries.
                                </div>
                            @endif
                            <button class="btn btn-xs btn-primary float-right exportToExcel"><i class="fa fa-file-excel"> Export</i> </button>
                            <table id="table2excel" class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th width="80%">Account Name</th>
                                    <th style="text-align: right">Debit</th>
                                    <th style="text-align: right">Credit</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($rows as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td style="text-align: right">{{ $item['debit'] > 0 ? number_format($item['debit'], 2) : '0.00' }}</td>
                                        <td style="text-align: right">{{ $item['credit'] > 0 ? number_format($item['credit'], 2) : '0.00' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No account balances found.</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <th>Total</th>
                                    <th style="border-bottom: double;border-top: double;text-align: right">{{ number_format($dr, 2) }}</th>
                                    <th style="border-bottom: double;border-top: double;text-align: right">{{ number_format($cr, 2) }}</th>
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
            $('.select2').select2();
        });
    </script>
    <script>
        var jq = $.noConflict();
        jq(document).ready(function(){
            $(".exportToExcel").click(function () {
                jq("#table2excel").table2excel({
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
