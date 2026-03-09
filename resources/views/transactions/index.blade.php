@extends('layouts.app')

@section('content')
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
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Code</th>
                                    <th>Imp/Exp</th>
                                    <th class="text-right">Price</th>
                                    <th>Currency</th>
                                    <th class="text-right">Unit</th>
                                    <th class="">Type</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-right">1</td>
                                    <td class="text-primary">Ahbab International</td>
                                    <td class="">14-03-2021</td>
                                    <td class="">GILDE CONTROL VALVE </td>
                                    <td class="text-right">H004</td>
                                    <td>Import</td>
                                    <td class="text-right">0.9</td>
                                    <td>US Dollar</td>
                                    <td class="text-right">1</td>
                                    <td class=""><span class=" shadow-none badge badge-success">Box</span></td>
                                </tr>
                                <tr>
                                    <td class="text-right">2</td>
                                    <td class="text-primary">M. Nouman</td>
                                    <td class="">16-03-2021</td>
                                    <td class="">LDPE ''LOTRENE'' FE8000</td>
                                    <td class="text-right">H009</td>
                                    <td>Export</td>
                                    <td class="text-right">0.5</td>
                                    <td>US Dollar</td>
                                    <td class="text-right">1</td>
                                    <td class=""><span class=" shadow-none badge badge-primary">Ship</span></td>
                                </tr>
                                <tr>
                                    <td class="text-right">3</td>
                                    <td class="text-primary">Abdulrehman</td>
                                    <td class="">17-03-2021</td>
                                    <td class="">Shirts (6105.1000)</td>
                                    <td class="text-right">H013</td>
                                    <td>Import</td>
                                    <td class="text-right">1</td>
                                    <td>US Dollar</td>
                                    <td class="text-right">1</td>
                                    <td class=""><span class=" shadow-none badge badge-success">Box</span></td>
                                </tr>
                                <tr>
                                    <td class="text-right">4</td>
                                    <td class="text-primary">M. Nouman</td>
                                    <td class="">18-03-2021</td>
                                    <td class="">LDPE ''LOTRENE'' FE8000</td>
                                    <td class="text-right">H009</td>
                                    <td>Export</td>
                                    <td class="text-right">0.5</td>
                                    <td>US Dollar</td>
                                    <td class="text-right">1</td>
                                    <td class=""><span class=" shadow-none badge badge-success">Box</span></td>
                                </tr>

                                <tr>
                                    <td class="text-right">5</td>
                                    <td class="text-primary">Mudassar Saif</td>
                                    <td class="">19-03-2021</td>
                                    <td class="">LDPE ''LOTRENE'' FE8000</td>
                                    <td class="text-right">H009</td>
                                    <td>Export</td>
                                    <td class="text-right">0.5</td>
                                    <td>US Dollar</td>
                                    <td class="text-right">1</td>
                                    <td class=""><span class=" shadow-none badge badge-success">Box</span></td>
                                </tr>
                                <tr>
                                    <td class="text-right">6</td>
                                    <td class="text-primary">M. Nouman</td>
                                    <td class="">20-03-2021</td>
                                    <td class="">Shirts (6105.1000)</td>
                                    <td class="text-right">H013</td>
                                    <td>Import</td>
                                    <td class="text-right">1</td>
                                    <td>US Dollar</td>
                                    <td class="text-right">1</td>
                                    <td class=""><span class=" shadow-none badge badge-primary">Box</span></td>
                                </tr>
                                <tr>
                                    <td class="text-right">7</td>
                                    <td class="text-primary">M. Nouman</td>
                                    <td class="">21-03-2021</td>
                                    <td class="">Shirts (6105.1000)</td>
                                    <td class="text-right">H013</td>
                                    <td>Import</td>
                                    <td class="text-right">1</td>
                                    <td>US Dollar</td>
                                    <td class="text-right">1</td>
                                    <td class=""><span class=" shadow-none badge badge-success">Box</span></td>
                                </tr>
                                <tr>
                                    <td class="text-right">8</td>
                                    <td class="text-primary">Mudassar Saif</td>
                                    <td class="">22-03-2021</td>
                                    <td class="">Shirts (6105.1000)</td>
                                    <td class="text-right">H013</td>
                                    <td>Import</td>
                                    <td class="text-right">1</td>
                                    <td>US Dollar</td>
                                    <td class="text-right">1</td>
                                    <td class=""><span class=" shadow-none badge badge-success">Box</span></td>
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