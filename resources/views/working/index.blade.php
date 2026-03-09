@extends('layouts.app')

@section('content')
    <style type="text/css">
        .table td, .table th{
            padding: 0.05rem!important;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Transaction List</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Transaction List</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-right">#</th>
                                    <th>Customer</th>
                                    <th style="text-align: center">Product</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Ahbab International</td>
                                    <td style="text-align: center">GILDE CONTROL VALVE</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" align="center">
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <td align="center">Ali Baba</td>
                                                <td align="center">Price</td>
                                                <td align="center">Units</td>
                                                <td align="center">Variance</td>
                                                <td align="center">Plus/Minus</td>
                                                <td align="center">% of Variance</td>
                                                <td align="center">Variance</td>
                                                <td align="center">Action</td>
                                            </tr>
                                            <tr>
                                                <td align="center">0.7</td>
                                                <td align="center">0.9</td>
                                                <td align="center">1</td>
                                                <td align="center">0.2</td>
                                                <td align="center">Plus</td>
                                                <td align="center">22.22</td>
                                                <td align="center">-25%</td>
                                                <td align="center"><span class="badge badge-success">Approved</span></td>
                                            </tr>
                                            <tr>
                                                <td align="center">weBoc</td>
                                                <td align="center">Price</td>
                                                <td align="center">Units</td>
                                                <td align="center">Variance</td>
                                                <td align="center">Plus/Minus</td>
                                                <td align="center">% of Variance</td>
                                                <td align="center">Variance</td>
                                                <td align="center">Action</td>
                                            </tr>
                                            <tr>
                                                <td align="center">0.6</td>
                                                <td align="center">0.9</td>
                                                <td align="center">1</td>
                                                <td align="center">0.2</td>
                                                <td align="center">Plus</td>
                                                <td align="center">22.22</td>
                                                <td align="center">-25%</td>
                                                <td align="center"><span class="badge badge-success">Approved</span></td>
                                            </tr>
                                            <tr>
                                                <td align="center">T-24</td>
                                                <td align="center">Price</td>
                                                <td align="center">Units</td>
                                                <td align="center">Variance</td>
                                                <td align="center">Plus/Minus</td>
                                                <td align="center">% of Variance</td>
                                                <td align="center">Variance</td>
                                                <td align="center">Action</td>
                                            </tr>
                                            <tr>
                                                <td align="center">0.8</td>
                                                <td align="center">0.9</td>
                                                <td align="center">1</td>
                                                <td align="center">0.2</td>
                                                <td align="center">Plus</td>
                                                <td align="center">22.22</td>
                                                <td align="center">-25%</td>
                                                <td align="center"><span class="badge badge-success">Approved</span></td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
    @include('Setup.Clients.modal')
    <script>
        function add_new() {
            $("#new").modal();
        }
    </script>
@endsection<!-- jQuery -->