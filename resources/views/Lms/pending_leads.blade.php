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
                            <li class="breadcrumb-item active">My Leads</li>
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
                        <div class="card-header">
                            <button class="btn btn-xs float-right filter filter-toggle">Filter <i class="fa fa-caret-down"></i> </button>
                            <div class="row filter-section" style="display: none;">
                                <div class="col-md-2 form-group">
                                    <input type="text" name="dt" class="form-control form-control-sm date" placeholder="Date From">
                                </div>
                                <div class="col-md-2 form-group">
                                    <input type="text" name="dt" class="form-control form-control-sm date" placeholder="Date to">
                                </div>
                                <div class="col-md-2 form-group">
                                    <input type="text" name="mobile" class="form-control form-control-sm" placeholder="Mobile">
                                </div>
                                <div class="col-md-2 form-group">
                                    <select name="status" class="form-control form-control-sm">
                                        <option value="">Pending</option>
                                        <option value="">Takenover</option>
                                        <option value="">Process</option>
                                        <option value="">Successfull</option>
                                        <option value="">Unsuccessfull</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-search"></i> </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Lead ID</th>
                                    <th>Contac Name</th>
                                    <th>Mobile</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="get_data">
                                @foreach($result as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->contact_name }}</td>
                                        <td>{{ $item->mobile }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td><span class="badge bg-warning">pending</span></td>
                                        <td>
                                            <a href="{{ url('lms/lead/') }}/{{ $item->id }}"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
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
@endsection<!-- jQuery -->