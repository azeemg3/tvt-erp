@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Client List</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item">Setup</li>
                            <li class="breadcrumb-item active">Client List</li>
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
                            <div class="row">
                            <div class="col-md-12">
                            <button style="float: right;" onclick="add_new()" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> </button>
                            </div>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>City</th>
                                    <th>Address 1</th>
                                    <th>Address 2</th>
                                    <th>Zip</th>
                                    <th>State</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-primary">Mr. Bilal</td>
                                    <td class="">Sb</td>
                                    <td class="">923239000595</td>
                                    <td>Bilal@gmail.com</td>
                                    <td>Lahore</td>
                                    <td>Lahore</td>
                                    <td>Neelam Block, Allama Iqbal Town</td>
                                    <td class="text-right">54000</td>
                                    <td class=""><span class=" shadow-none badge badge-success">Punjab</span></td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="http://localhost/bank-app/public/users/1/edit"><i class="fa fa-edit"></i></a>
                                        <form method="POST" action="http://localhost/bank-app/public/users/1" accept-charset="UTF-8" style="display:inline"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="C9WGVTzhonPP9zxMi4t9rVvOQd4BWSi9r3DNgBhL">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">Qamber Ali</td>
                                    <td class="">Ali</td>
                                    <td class="">923214574042</td>
                                    <td>qamberali@gmail.com</td>
                                    <td>Lahore</td>
                                    <td class="text-right">5557</td>
                                    <td>Sector G, Phase 6, DHA</td>
                                    <td class="text-right">54792</td>
                                    <td class=""><span class=" shadow-none badge badge-primary">Punjab</span></td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="http://localhost/bank-app/public/users/1/edit"><i class="fa fa-edit"></i></a>
                                        <form method="POST" action="http://localhost/bank-app/public/users/1" accept-charset="UTF-8" style="display:inline"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="C9WGVTzhonPP9zxMi4t9rVvOQd4BWSi9r3DNgBhL">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">M. Nouman</td>
                                    <td class="">Tariq</td>
                                    <td class="">923009189215</td>
                                    <td>Naouman55@gmail.com</td>
                                    <td>Lahore</td>
                                    <td class="text-right">5557</td>
                                    <td>Sector L, Phase 5, DHA</td>
                                    <td class="text-right">54600</td>
                                    <td class=""><span class=" shadow-none badge badge-warning">Punjab</span></td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="http://localhost/bank-app/public/users/1/edit"><i class="fa fa-edit"></i></a>
                                        <form method="POST" action="http://localhost/bank-app/public/users/1" accept-charset="UTF-8" style="display:inline"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="C9WGVTzhonPP9zxMi4t9rVvOQd4BWSi9r3DNgBhL">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">MS</td>
                                    <td class="">nimra</td>
                                    <td class="">923455061255</td>
                                    <td>nimrakhan22@gmail.com</td>
                                    <td>Lahore</td>
                                    <td class="text-right">5557</td>
                                    <td>street 6 ,sector R, DHA Phase 7</td>
                                    <td class="text-right">54000</td>
                                    <td class=""><span class=" shadow-none badge badge-success">Punjab</span></td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="http://localhost/bank-app/public/users/1/edit"><i class="fa fa-edit"></i></a>
                                        <form method="POST" action="http://localhost/bank-app/public/users/1" accept-charset="UTF-8" style="display:inline"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="C9WGVTzhonPP9zxMi4t9rVvOQd4BWSi9r3DNgBhL">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-primary">Sana</td>
                                    <td class="">Nawaz</td>
                                    <td class="">923425144455</td>
                                    <td>nawazkhan234@gmail.com</td>
                                    <td></td>
                                    <td class="text-right">5557</td>
                                    <td></td>
                                    <td class="text-right">54000</td>
                                    <td class=""><span class=" shadow-none badge badge-success">Punjab</span></td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="http://localhost/bank-app/public/users/1/edit"><i class="fa fa-edit"></i></a>
                                        <form method="POST" action="http://localhost/bank-app/public/users/1" accept-charset="UTF-8" style="display:inline"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="C9WGVTzhonPP9zxMi4t9rVvOQd4BWSi9r3DNgBhL">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">Usman</td>
                                    <td class="">Shahzad</td>
                                    <td class="">923334178302</td>
                                    <td></td>
                                    <td class="text-right">5557</td>
                                    <td>Lahore</td>
                                    <td>Block 2, Sector C , Township</td>
                                    <td class="text-right">54000</td>
                                    <td class=""><span class=" shadow-none badge badge-primary">Punjab</span></td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="http://localhost/bank-app/public/users/1/edit"><i class="fa fa-edit"></i></a>
                                        <form method="POST" action="http://localhost/bank-app/public/users/1" accept-charset="UTF-8" style="display:inline"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="C9WGVTzhonPP9zxMi4t9rVvOQd4BWSi9r3DNgBhL">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i> </button>
                                        </form>
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
    <!-- jQuery -->
    <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ URL::asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        });
        function add_new() {
            $("#new").modal();
        }
    </script>
@endsection<!-- jQuery -->