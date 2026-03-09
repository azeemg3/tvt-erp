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
                                                <td align="center" width="50%">Ahbab International Price</td>
                                                <td align="center">Ali Baba</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">0.7</td>
                                                <td align="center">0.2</td>
                                                <td align="center">2.22</td>
                                            </tr>
                                            <tr>
                                                <td align="center" width="50%">Ahbab International Price</td>
                                                <td align="center">WeBoc</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">0.8</td>
                                                <td align="center">0.1</td>
                                                <td align="center">11.11</td>
                                            </tr>
                                            <tr>
                                                <td align="center" width="50%">Ahbab International Price</td>
                                                <td align="center">T-24</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">2</td>
                                                <td align="center">-1.1</td>
                                                <td align="center">2</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: right">Average of Variance:</th>
                                    <td style="text-align: center"><span class="badge badge-success">11.78</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>M. Nouman</td>
                                    <td style="text-align: center">LDPE ''LOTRENE'' FE8000</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" align="center">
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <td align="center" width="50%">LDPE ''LOTRENE'' FE8000 Price</td>
                                                <td align="center">Ali Baba</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">0.7</td>
                                                <td align="center">0.2</td>
                                                <td align="center">2.22</td>
                                            </tr>
                                            <tr>
                                                <td align="center">LDPE ''LOTRENE'' FE8000 Price</td>
                                                <td align="center">WeBoc</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">0.8</td>
                                                <td align="center">0.1</td>
                                                <td align="center">11.11</td>
                                            </tr>
                                            <tr>
                                                <td align="center">LDPE ''LOTRENE'' FE8000 Price</td>
                                                <td align="center">T-24</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">2</td>
                                                <td align="center">-1.1</td>
                                                <td align="center">2</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: right">Average of Variance:</th>
                                    <td style="text-align: center"><span class="badge badge-success">13.47</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Abdulrehman</td>
                                    <td style="text-align: center">Shirts</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" align="center">
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <td align="center" width="50%">Abdulrehman Price</td>
                                                <td align="center">Ali Baba</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">0.7</td>
                                                <td align="center">0.2</td>
                                                <td align="center">2.22</td>
                                            </tr>
                                            <tr>
                                                <td align="center">Abdulrehman Price</td>
                                                <td align="center">WeBoc</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">0.8</td>
                                                <td align="center">0.1</td>
                                                <td align="center">11.11</td>
                                            </tr>
                                            <tr>
                                                <td align="center">Abdulrehman Price</td>
                                                <td align="center">T-24</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">2</td>
                                                <td align="center">-1.1</td>
                                                <td align="center">2</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: right">Average of Variance:</th>
                                    <td style="text-align: center"><span class="badge badge-success">10.33</span></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>M. Nouman</td>
                                    <td style="text-align: center">LDPE ''LOTRENE'' FE8000</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" align="center">
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <td align="center" width="50%">LDPE ''LOTRENE'' FE8000 Price</td>
                                                <td align="center">Ali Baba</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">0.7</td>
                                                <td align="center">0.2</td>
                                                <td align="center">2.22</td>
                                            </tr>
                                            <tr>
                                                <td align="center">LDPE ''LOTRENE'' FE8000 Price</td>
                                                <td align="center">WeBoc</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">0.8</td>
                                                <td align="center">0.1</td>
                                                <td align="center">11.11</td>
                                            </tr>
                                            <tr>
                                                <td align="center">LDPE ''LOTRENE'' FE8000 Price</td>
                                                <td align="center">T-24</td>
                                                <td align="center">Dif</td>
                                                <td align="center">%Dif</td>
                                            </tr>
                                            <tr>
                                                <td align="center">2.00</td>
                                                <td align="center">2</td>
                                                <td align="center">-1.1</td>
                                                <td align="center">2</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2" style="text-align: right">Average of Variance:</th>
                                    <td style="text-align: center"><span class="badge badge-success">10.33</span></td>
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
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
@endsection<!-- jQuery -->